<?php

namespace App\Console\Commands;

use App\Models\userModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email} {--firstname=Admin} {--lastname=User}';
    protected $description = 'Create (or promote) an admin account';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));

        if (Validator::make(['email' => $email], ['email' => 'required|email'])->fails()) {
            $this->error('Invalid email.');
            return self::FAILURE;
        }

        if (userModel::whereRaw('LOWER(email) = ?', [$email])->exists()) {
            $this->error('An account with that email already exists.');
            return self::FAILURE;
        }

        $password = $this->secret('Password (min 8 chars)');
        $confirm = $this->secret('Confirm password');

        if ($password !== $confirm || strlen((string) $password) < 8) {
            $this->error('Passwords must match and be at least 8 characters.');
            return self::FAILURE;
        }

        userModel::create([
            'photos' => 'default.png',
            'firstname' => $this->option('firstname'),
            'lastname' => $this->option('lastname'),
            'email' => $email,
            'password' => Hash::make($password),
            'is_active' => 1,
            'is_admin' => 1,
            'email_verified' => 1,
        ]);

        $this->info("Admin created: {$email}");
        return self::SUCCESS;
    }
}