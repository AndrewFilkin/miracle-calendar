<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class VkNotificationController extends Controller
{
    public function send()
    {
        $answer = $this->send_vk(713121208, "Test Message");

        return $answer;
    }

    function send_vk($vk_user_id, $text_source)
    {
        $url = "https://api.vk.com/method/messages.send";
        $client = new Client();

        $random_id = random_int(100000000, 999999999);

        $response = $client->post($url, [
            'form_params' => [
                'user_id' => $vk_user_id, // needed for VK API
                'random_id' => $random_id,
                'v' => '5.199',
                'access_token' => env('VK_TOKEN'), // Поместите ваш токен в .env файл
                'message' => $text_source
            ],
            'verify' => false
        ]);

        $answer = (string)$response->getBody();


        if (strpos(" " . $answer, 'error')) {
            return response()->json(['message' => 'Message not send'], 409);
        }

        return response()->json(['message' => 'Message send']);

//        if (!strpos(" " . $answer, '{"response":')) {
//            return response()->json(['message' => 'Message send']);
//        }


    }

}
