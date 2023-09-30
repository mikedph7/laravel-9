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

    const EMAILS_INDEX = 'emails';

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

    /**
     * @param EmailRequest $request
     * @return JsonResponse
     */
    public function send(EmailRequest $request): JsonResponse
    {
        $params = $request->get('data');
        $success = 0;

        foreach ($params as $param) {
            if ($id = $this->elasticsearchHelper->store(self::EMAILS_INDEX, $param)) {
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

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json([
            'emails' => $this->elasticsearchHelper->retrieve(self::EMAILS_INDEX)
        ]);
    }
}
