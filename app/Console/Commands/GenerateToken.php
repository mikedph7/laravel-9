<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateToken extends Command
{
    protected $signature = 'token:generate {user_id}';
    protected $description = 'Generate a personal access token for a user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $token = $user->createToken('my-token-name')->plainTextToken;

        $this->info('Token generated successfully:');
        $this->info('Token: ' . $token);
    }
}
