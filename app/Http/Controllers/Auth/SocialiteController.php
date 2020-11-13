<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function handleProviderDeletingCallback(Request $request) : JsonResponse
    {
        $data = [];
        
        $this->validate($request,[
            'signed_request' => 'required',
        ]);

        $signed_request = $request->signed_request;
        // $data = $this->parse_signed_request($signed_request);
        // $user_id = $data['user_id'];
        
        // // Start data deletion
        $status_url = 'https://www.medcal.pl/deletion?id=abc123'; // URL to track the deletion
        $confirmation_code = 'abc123'; // unique code for the deletion request
        
        $data = [
          'url' => $status_url,
          'confirmation_code' => $confirmation_code
        ];        

        return response()->json($data);        
    }

    private function base64_url_decode($input) 
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    private function parse_signed_request($signed_request)
    {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
        $secret = env('FACEBOOK_CLIENT_SECRET'); // Use your app secret here      
        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);
        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
          error_log('Bad Signed JSON signature!');
          return null;
        }
        return $data;
    }
}
