<?php

namespace App\Traits;

trait WablasTraits
{
    public static function sendText(Array $text)
    {
        $curl = curl_init();
        $token = env('WABLAS_API_KEY');
        $payload = ['data' => $text];

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ]);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL,  env('WABLAS_DOMAIN_SERVER') . "/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);

        // return $result;
    }
}
