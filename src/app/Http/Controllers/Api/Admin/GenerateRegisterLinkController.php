<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterLink;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GenerateRegisterLinkController extends Controller
{
    public function generate()
    {
        $code = Str::random(32);
        $registerLink = RegisterLink::create([
            'code' => $code,
        ]);

        if ($registerLink) {
            return response()->json(['link created: ' => $code], 201);
        }
    }
}
