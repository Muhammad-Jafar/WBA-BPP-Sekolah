<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\APIInterface;
use App\Models\CashTransaction;
use App\Http\Controllers\Controller;
// use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\CashTransactionEditResource;
use App\Http\Resources\CashTransactionShowResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CashTransactionController extends Controller implements APIInterface
{
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

            // return response()->json([
            //     'error' => false,
            //     'message' => 'Successfully to charge',
            //     'paymentResult' => $result,
            // ]);

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

    public function show(int $id): JsonResponse
    {
        $cash_transactions = new CashTransactionShowResource(CashTransaction::with('students:id,name', 'users:id,name')->findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $cash_transactions
        ]);
    }

    public function edit(int $id): JsonResponse
    {
        $cash_transactions = new CashTransactionEditResource(CashTransaction::with('students:id,name', 'users:id,name')->findOrFail($id));

        return response()->json([
            'code' => Response::HTTP_OK,
            'data' => $cash_transactions
        ]);
    }
}
