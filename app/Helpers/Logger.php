<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    public static function log($e, $data = null, $type = 'error'): void
    {
        Log::$type($e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'data' => $data,
        ]);
    }
}
