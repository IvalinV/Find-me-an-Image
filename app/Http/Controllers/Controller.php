<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function makeRequest()
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $OPENAI_API_KEY = env('OPENAI_API_SECRET');
        $data = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'Write me a short story?'
                    ]
                ]
        ];
        // return $data;

        $response = Http::timeout(380)
            ->acceptJson()
            ->withToken($OPENAI_API_KEY)
            ->post($url, $data)->body();
        
        return json_decode($response)->choices[0]->message->content; 
    }
}
    