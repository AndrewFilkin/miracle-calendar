<?php

namespace App\Http\Controllers\Api\Task;

use App\Actions\SendVkNotification;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Requests\Api\Notification\StoreVkUserIdRequest;
use Illuminate\Support\Facades\Config;

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
}
