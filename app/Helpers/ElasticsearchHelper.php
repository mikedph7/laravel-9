<?php

namespace App\Helpers;

use App\Models\Email;
use App\Utilities\Contracts\ElasticsearchHelperInterface;

class ElasticsearchHelper implements ElasticsearchHelperInterface
{
    public function store(array $data)
    {
        $email = new Email();
        $email->data = json_encode($data);
        if ($res = $email->saveToIndex()) {
            return $res['_id'];
        }
        return false;
    }

    public function retrieve(string $key)
    {
        // TODO: Implement retrieve() method.
    }
}
