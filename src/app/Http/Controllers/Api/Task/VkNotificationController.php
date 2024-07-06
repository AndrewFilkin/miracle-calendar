<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use App\Http\Requests\Api\Notification\StoreVkUserIdRequest;

class VkNotificationController extends Controller
{

    public function storeVkUserId(StoreVkUserIdRequest $request)
    {
        $data = $request->validated();

        $userId = auth()->user()->id;

        if (!$userId) {
            return response()->json(['message' => 'Access close'], 401);
        }

        $user = User::find($userId);
        $user->vk_user_id = (int)$data['vk_user_id'];
        $user->save();

        return response()->json(['message' => 'Vk user id save']);

    }

    public function send()
    {
        $answer = $this->send_vk(496279615, "Задача создана");

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
