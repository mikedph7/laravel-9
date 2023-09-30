<?php

namespace App\Helpers;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Exception;

class ElasticsearchHelper implements ElasticsearchHelperInterface
{
    protected Client $clientBuilder;
    protected const PARAMS = [
            'type' => 'doc',
        ];

    public function __construct()
    {
        $this->clientBuilder = ClientBuilder::create()->build();
    }

    public function store(string $index, array $data)
    {
        try {
            $params = array_merge(self::PARAMS, [
                'index' => $index,
                'body' => [
                    'data' => $data,
                ]
            ]);

            $response = $this->clientBuilder->index($params);

            if (!$response['created']) {
                return false;
            }
            return $response['_id'];
        } catch (Exception $e) {
            Logger::log($e);
            return false;
        }

    }

    public function retrieve(string $key): array
    {
        try {
            $emails = [];
            $params = self::PARAMS;
            $params['index'] = $key;
            $response = $this->clientBuilder->search($params);

            $hits = $response['hits']['hits'];

            foreach ($hits as $hit) {
                $source = $hit['_source'];
                $emails[] = ['id' => $hit['_id']] + $source['data'];
            }
            return $emails;

        } catch (Missing404Exception $e) {
            Logger::log($e);
            return [];
        }
    }
}
