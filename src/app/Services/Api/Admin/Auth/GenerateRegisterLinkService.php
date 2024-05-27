<?php


namespace App\Services\Api\Admin\Auth;


use App\Models\RegisterLink;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GenerateRegisterLinkService
{
    public $answer;

    public function generateRegisterLink()
    {
        $twoDaysAgo = Carbon::now()->subDays(2);
        RegisterLink::where('created_at', '<', $twoDaysAgo)
            ->delete();

        $code = Str::random(32);
        $registerLink = RegisterLink::create([
            'code' => $code,
        ]);

        if ($registerLink) {
            $this->answer = response()->json(['link_created: ' => $code], 201);
        } else {
            $this->answer = response()->json(['message' => 'something wrong'], 409);
        }
    }
}
