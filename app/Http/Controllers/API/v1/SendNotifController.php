<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Student;
use App\Traits\WablasTraits;

class SendNotifController extends Controller
{

    public function sendNotif()
    {
        $studentId = Student::find(1);
        
        $phone = $studentId->select('phone_number')->first();
        // $message = '*Admin BPP SMAN 1 ALAS* \n Terimakasih telah melakukan pembayaran uang BPP sebesar Rp 140.000 untuk jangka waktu 1 Bulan.';
        // $dataMessage =  [
        //     'phone' => '087703055755',
        //     'message' => '*Admin BPP SMAN 1 ALAS* \n Terimakasih telah melakukan pembayaran uang BPP sebesar Rp 140.000 untuk jangka waktu 1 Bulan.',
        //     'secret' => false,
        //     'retry' => false,
        //     'isGroup' => false,
        // ];

        // // Log::info('Sending message', ['student_id' => $studentId, 'phone' => $phone, 'message' => $message ]);

        // $response = WablasTraits::sendText($dataMessage);

        // return response()->json([
        //     'error' => false,
        //     'message' => 'Success to send message',
        //     'studentId' => 1,
        //     'phone' => '087703055755',
        //     'body' => '*Admin BPP SMAN 1 ALAS* \n Terimakasih telah melakukan pembayaran uang BPP sebesar Rp 140.000 untuk jangka waktu 1 Bulan.',
        //     'result' => $response,
        // ]);


        $curl = curl_init();
        $token = 'tMPbzDibDulKUbSxD2oLFUrn75PDcjCVIug7NK9tl3Fhak355KVdCtWoc8GTZG0Q';
        $random = true;
        $payload = [
            "data" => [
                [
                    'phone' => '087703055755',
                    'message' => 'hello there',
                ],
                [
                    'phone' => '087761069291',
                    'message' => 'hello there',
                ]
            ]
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);

        //  return response()->json([
        //     'error' => false,
        //     'message' => 'Success to send message',
        //     'studentId' => 1,
        //     'phone' => '087703055755',
        //     'body' => '*Admin BPP SMAN 1 ALAS* \n Terimakasih telah melakukan pembayaran uang BPP sebesar Rp 140.000 untuk jangka waktu 1 Bulan.',
        //     'result' => $result,
        // ]);
    }
}
