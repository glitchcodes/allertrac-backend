<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('admin:create', function () {
    $first_name = $this->ask('First name');
    $last_name = $this->ask('Last name');

    // Emails should be unique
    $email = $this->ask('Email');

    $emailExists = DB::table('users')->where('email', $email)->exists();

    // If email already exists, end the command
    if ($emailExists) {
        return $this->error('This email already exists');
    }

    $password = '';
    $is_password_confirmed = false;

    while (!$is_password_confirmed) {
        $password = $this->secret('Password');
        $confirm_password = $this->secret('Confirm password');

        if ($password === $confirm_password) {
            $is_password_confirmed = true;
        } else {
            $this->error('Passwords do not match. Try again');
        }
    }

    DB::table('users')->insert([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    return $this->info('Administrator account created');
})->purpose('Create an administrator account');

Artisan::command('admin:update-password', function () {
    $email = $this->ask('Account email');

    // Check if email exists in the administrator table
    $exists = DB::table('users')
        ->where('email', $email)
        ->where('role', 'admin')
        ->exists();

    if (!$exists) {
        return $this->error('Account not found');
    }

    $password = $this->secret('New password');

    if (empty($password)) return $this->error('Password required');

    $confirm_password = $this->secret('Confirm password');

    if ($password != $confirm_password) {
        return $this->error('Passwords do not match');
    }

    DB::table('users')->where('email', $email)->update(['password' => Hash::make($password)]);

    return $this->info('Administrator account successfully updated');
})->purpose("Update password for an administrator account");

Artisan::command('admin:demote', function () {
    $this->info('Demote an administrator account to user');

    $email = $this->ask('Account email');
    $exists = DB::table('users')
        ->where('email', $email)
        ->where('role', 'admin')
        ->exists();

    // Check if email exists
    if (!$exists) {
        return $this->error('Account not found');
    }

    DB::table('users')->where('email', $email)->update([
        'role' => 'user',
    ]);

    return $this->info('Administrator account successfully demoted');
})->purpose("Demote an administrator account to user");
