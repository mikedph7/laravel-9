<?php

namespace App\Helpers;

use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisHelper implements RedisHelperInterface
{

    public function store(string $key, array $data)
    {
        $serializedData = serialize($data);
        Redis::set($key, $serializedData);
    }

    public function retrieve(string $key)
    {
        $serializedData = Redis::get($key);

        if ($serializedData) {
            return unserialize($serializedData);
        }

        return null;
    }
}
