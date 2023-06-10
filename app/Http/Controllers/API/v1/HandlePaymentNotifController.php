<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;
use App\Models\CashTransaction;
use App\Models\Bill;
use App\Models\Student;
use App\Traits\WablasTraits;

class HandlePaymentNotifController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();

        Log::info("incoming-midtrans", ['payload' => $payload]);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];

        $reqSignature = $payload['signature_key'];
        $ownSignature = hash('sha512', $orderId.$statusCode.$grossAmount.config('midtrans.server_key'));

        if ($ownSignature != $reqSignature)
        {
            return response()->json([
                'error' => true,
                'message' => 'Invalid signature',
            ], 401);
        }

        $transactionStatus = $payload['transaction_status'];

        $order = CashTransaction::find($orderId);
        if (!$order)
        {
            return response()->json([
                'error' => true,
                'message' => 'Transaction not found',
            ], 400);
        }

        if ($transactionStatus == 'settlement')
        {
            $order->is_paid = 'APPROVED';
            $order->save();
            // $order->update('is-paid', 'APPROVED');
            $billId = $order->bill_id;
            $amount = $order->amount;

            // $bills = DB::table('bills')->where('id', $billId)->select('recent_bill')->first();
            $bills = Bill::find($billId);
            Bill::where('bill_id', $billId)->update(['recent_bill', $bills->recent_bill + $amount]);


            $studentId = $order->student_id;
            $phone = Student::find($studentId)->select('phone_number')->first();
            $message = '*Admin BPP SMAN 1 ALAS* \n Terimakasih telah melakukan pembayaran uang BPP sebesar Rp '.$amount.' untuk jangka waktu 1 Bulan.';
            $dataMessage =  [
                'phone' => $phone,
                'message' => $message,
                'secret' => false,
                'retry' => false,
                'isGroup' => false,
            ];

            WablasTraits::sendText($dataMessage);

            return response()->json([
                'error' => false,
                'message' => 'Success to payment',
            ]);

        }
        else if ($transactionStatus == 'expire')
        {
            $order->is_paid = 'REJECTED';
            $order->save();

            return response()->json([
                'error' => false,
                'message' => 'Payment has expired',
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
        ]);
    }
}
