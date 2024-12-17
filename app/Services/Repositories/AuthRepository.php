<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Traits\HasRepositoryRoof;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    use HasRepositoryRoof;

    public User|null $user;

    public function attempt($email, $password, $guard = 'web'): static
    {
        $user = User::where('email', $email)->first();

        if (!$user || Hash::check($password, $user->password)) {
            return $this->setError(__('Invalid credentials'));
        }

        $user->update([
            'last_login_at' => now(),
        ]);

        if ($guard == "web") {
            Auth::login($user);
        } else {
            $user->tokens()->delete();
        }

        $this->user = $user;

        return $this;
    }

    public function logout()
    {

    }

    public function sendPasswordResetLink(string $email)
    {

    }

    public function changePassword($currentPassword, $newPassword)
    {
        if (!$this->transactionBy) {
            $this->setError(__('Transaction user not found'));
            return $this;
        }
    }

    public function getLoginMeta()
    {
        if (!$this->user) {
            $this->setError(__('User not found'));
            return $this;
        }
    }
}
