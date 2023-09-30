<?php

namespace App\Services;

use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Helpers\Logger;

class EmailService
{

    public function send($params): void
    {
        try {
            $user = auth('sanctum')->user();
            Mail::to($params['email'])->send(
                new MyEmail($user, $params)
            );
        } catch (Exception $e) {
            Logger::log($e, ['user'=>$user->id]);
        }
    }
}
