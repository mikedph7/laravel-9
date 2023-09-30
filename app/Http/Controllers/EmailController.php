<?php

namespace App\Http\Controllers;

use App\Helpers\ElasticsearchHelper;
use App\Helpers\RedisHelper;
use App\Http\Requests\EmailRequest;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;

class EmailController extends Controller
{
    protected EmailService $emailService;
    protected RedisHelper $redisHelper;
    protected ElasticsearchHelper $elasticsearchHelper;

    public function __construct(
        EmailService $emailService,
        RedisHelper $redisHelper,
        ElasticsearchHelper $elasticsearchHelper
    )
    {
        $this->emailService = $emailService;
        $this->redisHelper = $redisHelper;
        $this->elasticsearchHelper = $elasticsearchHelper;
    }

    public function send(EmailRequest $request): JsonResponse
    {
        $params = $request->get('data');
        $success = 0;

        foreach ($params as $param) {
            if ($id = $this->elasticsearchHelper->store($param)) {
                $this->redisHelper->store($id, $param);
                $this->emailService->send($param);
                ++$success;
            }
        }

        return response()->json([
            'email_count' => count($params),
            'success_count' => $success,
        ]);
    }

    public function list()
    {
        return response()->json([
            'emails' => $this->elasticsearchHelper->retrieve('emails')
        ]);
    }
}
