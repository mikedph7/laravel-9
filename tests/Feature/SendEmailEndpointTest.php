<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendEmailEndpointTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_send_email_endpoint(): void
    {
        $data['data'] = [
            [
                'email' => 'johnm.raquel@gmail.com',
                'subject' => 'Test Email',
                'body' => 'Hello World!'
            ],
            [
                'email' => 'test@sample.com',
                'subject' => 'Test Email 2',
                'body' => 'Hello World Again!'
            ],
        ];

        $user = User::factory()->create(
            ['name'=>'user1']
        );

        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/'.$user->name.'/send', $data);

        $params_count = count($data['data']);
        $response
            ->assertStatus(200)
            ->assertJson([
                'email_count' => $params_count,
                'success_count' => $params_count,
            ]);
    }

}
