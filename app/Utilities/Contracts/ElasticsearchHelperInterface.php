<?php

namespace App\Utilities\Contracts;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param string $index
     * @param array $data
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function store(string $index, array $data);
    public function retrieve(string $key);

}
