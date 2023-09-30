<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Elasticsearch\ClientBuilder;

class Email extends Model
{
    use Searchable;

    protected $fillable = ['data'];


    public function saveToIndex()
    {
        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'email',
            'id' => $this->id,
            'type' => "doc",
            'body' => [
                'data' => $this->data,
            ],
        ];

        $response = $client->index($params);
        if (!$response['created']) {
            return false;
        }
        return $response;
    }
}
