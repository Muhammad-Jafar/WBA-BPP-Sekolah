<?php

namespace App\Http\Controllers\API\v1;

use App\Models\CashTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashTransactionShowResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Bill;
use App\Models\Student;
use App\Traits\WablasTraits;

class CashTransactionController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $cash_transactions = new CashTransactionShowResource(CashTransaction::with('students:id,name', 'users:id,name')->findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $cash_transactions
        ]);
    }

    /**
     * Handle the payment request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'bill_id' => 'required',
            'student_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'amount' => 'required|int',
            'note' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => true,
                'message' => "Invalid data passed",
                'data' => $validator->errors()
            ]);
        }

        try {
            DB::beginTransaction();
                $transaction_id = Str::uuid()->toString();
                $response = Http::withBasicAuth(config('midtrans.server_key'), '')
                    ->post('https://api.sandbox.midtrans.com/v2/charge', [
                        'payment_type' => 'bank_transfer',
                        'transaction_details' => [
                            'order_id' => $transaction_id,
                            'gross_amount' => $request->amount
                        ],
                        'customer_details' => [
                            'first_name' => $request->name,
                            'email' => $request->email,
                        ],
                        'bank_transfer' => [
                            'bank' => 'bni'
                        ],
                    ]
                );
                if ($response->failed())
                {
                    return response()->json([
                        'error' => true,
                        'message' => "failed to charge transaction"
                    ], 500);
                }

                $result = $response->json();
                if ($result['status_code'] != '201')
                {
                    return response()->json([
                        'error' => true,
                        'message' => $result['status_message']
                    ], 500);
                }

                DB::table('cash_transactions')->insert([
                    'id' => $transaction_id,
                    'transaction_code' => 'TRANS-'.Str::random(6),
                    'bill_id' => $request->bill_id,
                    'user_id' => 1,
                    'student_id' => $request->student_id,
                    'amount' => $request->amount,
                    'paid_on' => now(),
                    'note' => $request->note,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Successfully to charge',
                'paymentResult' => [
                    'amount' => $request->amount,
                    'va_number' => $result['va_numbers'][0]['va_number'],
                    'expiry_time' => $result['expiry_time'],
                ]
            ]);

        }catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle the incoming status request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        $validatior = Validator::make($request->all(), ['transaction_id' => 'required' ]);
        if ($validatior->fails())
        {
            return response()->json([
                'error' => true,
                'message' => "Transaction not found",
                'data' => $validatior->errors(),
            ]);
        }

        try {
            $response = Http::withBasicAuth(config('midtrans.server_key'), '')
            ->get('https://api.sandbox.midtrans.com/v2/'.$request->transaction_id.'/status');

            if ($response->failed())
            {
                return response()->json([
                    'error' => true,
                    'message' => "failed to make request"
                ], 500);
            }

            $result = $response->json();
            // Log::info("incoming-midtrans", ['payload' => $result]);

            $ownSignature = hash('sha512', $request->transaction_id.$result['status_code'].$result['gross_amount'].config('midtrans.server_key'));
            if ($ownSignature != $result['signature_key'])
            {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid signature',
                ], 401);
            }

            $order = CashTransaction::find($request->transaction_id);
            if ($result['transaction_status'] == 'settlement')
            {
                $order->where('id', $order->id)->update(['is_paid' => 'APPROVED']);

                $amount = $order->amount;
                $bills = Bill::find($order->bill_id);
                $bills->where('id', $order->bill_id)->update(['recent_bill' => $bills->recent_bill + $amount]);

                $student = Student::find($order->student_id);
                $phone = $student['phone_number'];
                $expire = $amount % 70000 == 0;
                $message = <<<EOT
                _from_ : Admin BPP SMAN 1 ALAS
                _to_ : Orang tua siswa

                Terimakasih telah melakukan pembayaran uang BPP sebesar Rp *$amount* untuk jangka waktu $expire Bulan.
                EOT;
                $dataMessage =  [
                    'phone' => $phone,
                    'message' => $message,
                ];
                WablasTraits::sendText($dataMessage);

                return response()->json([
                    'error' => false,
                    'message' => 'Payment successful',
                ]);
            }
            else if ($result['transaction_status'] == 'expire')
            {
                DB::table('cash_transactions')->where('id', $order->id)->update(['is_paid' => 'REJECTED']);

                return response()->json([
                    'error' => false,
                    'message' => 'Payment has expired',
                ]);
            }
            else if ($result['transaction_status'] == 'pending')
            {
                return response()->json([
                    'error' => false,
                    'message' => 'There is no transaction has done',
                ]);
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => "Payment Error: " . $e->getMessage(),
            ]);
        }
    }
}
