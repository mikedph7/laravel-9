<?php

namespace App\Utilities\Contracts;

interface RedisHelperInterface {
    /**
     * Store the id of a message along with a message subject in Redis.
     *
     * @param string $key
     * @param array $data
     * @return mixed
     */
    public function store(string $key, array $data);
    public function retrieve(string $key);
}
