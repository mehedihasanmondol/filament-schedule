<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MakeFilamentUser extends Command
{
    protected $signature = 'make:app-user';
    protected $description = 'Create a new Filament user with mobile field';

    public function handle()
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email address');
        $mobile = $this->ask('Mobile number');
        $password = $this->secret('Password');

        // Validate inputs
        $this->validateInputs($email, $mobile, $password);

        // Create the user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'password' => Hash::make($password),
        ]);

        $this->info("Filament user {$user->name} created successfully.");
    }

    protected function validateInputs($email, $mobile, $password)
    {
        // Check if the email and mobile are unique
        $this->validateEmail($email);
        $this->validateMobile($mobile);
        $this->validatePassword($password);
    }

    protected function validateEmail($email)
    {
        if (User::where('email', $email)->exists()) {
            $this->error('The email address is already taken.');
            exit;
        }
    }

    protected function validateMobile($mobile)
    {
        if (User::where('mobile', $mobile)->exists()) {
            $this->error('The mobile number is already taken.');
            exit;
        }
    }

    protected function validatePassword($password)
    {
        if (strlen($password) < 6) {
            $this->error('The password must be at least 6 characters.');
            exit;
        }
    }
}
