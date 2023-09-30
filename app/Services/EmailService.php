<?php

namespace App\Services;

use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;

class EmailService
{

    public function send($params)
    {
        $user = auth('sanctum')->user();
        Mail::to($params['email'])->send(
            new MyEmail($user, $params)
        );
    }
}
