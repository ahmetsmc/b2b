<?php

namespace App\Console\Commands\Dashboard;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a dashboard admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter a fullname');
        $email = $this->ask('Enter a email');
        $password = $this->secret('Enter a password');

        if (!$name || !$email || !$password) {
            $this->error('Name, email and password fields required');
        } else {
            try {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'email_verified_at' => now()
                ]);

                $user->syncRoles('sa');

                $this->info('System admin account created');

            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
    }
}
