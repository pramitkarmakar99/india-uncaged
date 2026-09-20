<?php

use Illuminate\\Support\\Facades\\Artisan;

Artisan::command('indiauncaged:info', function () {
    $this->info('India Uncaged foundation is installed.');
})->purpose('Display India Uncaged application information');


Artisan::command('indiauncaged:create-owner', function () {
    if (\App\Models\User::where('role', 'owner')->exists()) {
        $this->error('An owner already exists.');
        return 1;
    }

    $name = $this->ask('Owner name');
    $email = $this->ask('Owner email');
    $password = $this->secret('Owner password');

    if (! $name || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $password || strlen($password) < 12) {
        $this->error('Name, a valid email, and a password of at least 12 characters are required.');
        return 1;
    }

    \App\Models\User::create([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'role' => 'owner',
    ]);

    $this->info('Owner account created.');
    return 0;
})->purpose('Create the first India Uncaged owner account');
