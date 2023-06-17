<?php

namespace App\Services\Midtrans;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\Log;

class Transaction
{
     /**
     * Create transaction.
     *
     * @param $params Transaction options
     * @throws Exception
     */
    public static function charge($payload): JsonResponse
    {
        $response = Http::withBasicAuth(config('midtrans.server_key'), '')
        ->post(Config::getBaseUrl() .'charge', [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'order_id' => $payload['transaction_id'],
                'gross_amount' => $payload['amount']
            ],
            'customer_details' => [
                'first_name' => $payload['name'],
                'email' => $payload['email'],
            ],
            'bank_transfer' => [
                'bank' => 'bni'
            ],
        ]);
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

        return response()->json([
            'error' => false,
            'message' => 'Successfully to charge',
            'paymentResult' => [
                'request_id' => $payload['transaction_id'],
                'amount' => $payload['amount'],
                'va_number' => $result['va_numbers'][0]['va_number'],
                'expiry_time' => $result['expiry_time'],
            ]
        ]);
    }

    /**
     * Retrieve transaction status
     *
     * @param string $id Order ID or transaction ID
     * @throws Exception
     */
    public static function status($id): JsonResponse
    {
        $response = Http::withBasicAuth(config('midtrans.server_key'), '')
        ->get(Config::getBaseUrl() . $id . '/status');
        if ($response->failed())
        {
            return response()->json([
                'error' => true,
                'message' => "failed to see transaction status"
            ], 500);
        }

        $result = $response->json();
        $ownSignature = hash('sha512', $result['order_id'].$result['status_code'].$result['gross_amount'].config('midtrans.server_key'));
        if ($ownSignature != $result['signature_key'])
        {
            return response()->json([
                'error' => true,
                'message' => 'Invalid signature',
            ], 401);
        }

        if ($result['transaction_status'] == 'settlement')
        {
            return response()->json([
                'error' => false,
                'message' => 'Payment successful',
                'transaction_status' => $result['transaction_status'],
            ]);
        }
        else if ($result['transaction_status'] == 'expire')
        {
            return response()->json([
                'error' => false,
                'message' => 'Payment has expired',
                'transaction_status' => $result['transaction_status'],
            ]);
        }
        else if ($result['transaction_status'] == 'pending')
        {
            return response()->json([
                'error' => false,
                'message' => 'Transaction has not been paid',
                'transaction_status' => $result['transaction_status'],
            ]);
        }
    }


}
