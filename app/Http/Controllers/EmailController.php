<?php

namespace App\Http\Controllers;

use App\Helpers\ElasticsearchHelper;
use App\Helpers\RedisHelper;
use App\Http\Requests\EmailRequest;
use App\Models\Email;
use App\Services\EmailService;

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

    // TODO: finish implementing send method
    public function send(EmailRequest $request)
    {
        $params = $request->get('data');

        foreach ($params as $param) {
            $id = $this->elasticsearchHelper->store($param);
            $this->redisHelper->store($id, $param);
            $this->emailService->send($param);
        }

    }

    //  TODO - BONUS: implement list method
    public function list()
    {
        // TODO impelement search in laravel/scout
        $email = Email::search('*')->get();
    }
}
