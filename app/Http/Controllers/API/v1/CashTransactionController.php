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
use App\Models\Bill;
use App\Models\Student;
use App\Traits\WablasTraits;
use App\Services\Midtrans\Transaction;

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
            $transaction_id = Str::uuid()->toString();
            $payload = [
                'transaction_id' => $transaction_id,
                'amount' => $request->amount,
                'name' => $request->name,
                'email' => $request->email,
            ];

            $response = Transaction::charge($payload);

            DB::beginTransaction();
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

            return $response;

        }catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

        /**
     * Handle the incoming notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleNotification(Request $request)
    {

        $payload = $request->all();
        // Log::info("incoming-midtrans", ['payload' => $payload]);

        $ownSignature = hash('sha512', $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('midtrans.server_key'));
        if ($ownSignature != $payload['signature_key'])
        {
            return response()->json([
                'error' => true,
                'message' => 'Invalid signature',
            ], 401);
        }

        try {
            $order = CashTransaction::find($payload['order_id']);
            if ($payload['transaction_status'] == 'settlement')
            {
                $order->where('id', $order->id)->update(['is_paid' => 'APPROVED']);

                $amount = $order->amount;
                $bills = Bill::find($order->bill_id);

                if (($amount + $bills->recent_bill) > $bills->billings)
                {
                   return response()->json([
                    'error' => true,
                    'message' => "The billings has been done"
                   ]);
                }
                else if (($amount + $bills->recent_bill) == $bills->billings)
                {
                    $bills->where('id', $order->bill_id)->update([
                        'recent_bill' => $bills->recent_bill + $amount,
                        'status' => 'DONE'
                    ]);
                }
                else
                {
                    $bills->where('id', $order->bill_id)->update(['recent_bill' => $bills->recent_bill + $amount]);
                }

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
                    'transaction_status' => $payload['transaction_status'],
                ]);
            }
            else if ($payload['transaction_status'] == 'expire')
            {
                DB::table('cash_transactions')->where('id', $order->id)->update(['is_paid' => 'REJECTED']);

                return response()->json([
                    'error' => false,
                    'message' => 'Payment has expired',
                    'transaction_status' => $payload['transaction_status'],
                ]);
            }
            else if ($payload['transaction_status'] == 'pending')
            {
                return response()->json([
                    'error' => false,
                    'message' => 'There is no transaction has done',
                    'transaction_status' => $payload['transaction_status'],
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

        $response = Transaction::status($request->transaction_id);
        return $response;
    }
}
