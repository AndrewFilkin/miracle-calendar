<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SendNotificationToVkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification-to-vk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to vk';


    function sent_vk($vk_user_id, $text_source): void
    {
        $url = "https://api.vk.com/method/messages.send";
        $client = new Client();

        $random_id = random_int(100000000, 999999999);

        $response = $client->post($url, [
            'form_params' => [
                'user_id' => $vk_user_id, // needed for VK API
                'random_id' => $random_id,
                'v' => '5.199',
                'access_token' => Config::get('app.vk_token'), // Поместите ваш токен в .env файл
                'message' => $text_source
            ],
            'verify' => false
        ]);

//        $answer = (string)$response->getBody();
//        if (strpos(" " . $answer, 'error')) {
//            dd(env('VK_TOKEN'));
//            return response()->json(['message' => 'Message not send'], 409);
//        }
//        echo 'Message send' . "\n";
//        return response()->json(['message' => 'Message send']);

    }

    public function handle()
    {
        $elevenMinutesAgo = Carbon::now();

        $tasks = Task::where('start_date', '<=', $elevenMinutesAgo)
            ->where('is_sent_vk_notification', '=', false)
            ->get();

        // Перебрать все задачи
        foreach ($tasks as $task) {
            $task->is_sent_vk_notification = true;
            $task->save();
            // Получить всех пользователей, связанных с этой задачей
            $users = $task->users;

            foreach ($users as $user) {
                if ($user->vk_user_id) {
                    try {
                        $this->sent_vk($user->vk_user_id, 'Test Send Message link task');
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            }
        }
    }
}
