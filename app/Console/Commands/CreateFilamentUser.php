<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    protected $signature = 'create:filament-user';
    protected $description = 'Creates a new Filament admin user';

    public function handle()
    {
        // Membuat user admin baru
        User::create([
            'name' => 'Admin User',
            'email' => 'aku@gmail.com',
            'password' => Hash::make('123'), // Pastikan password dienkripsi
            'is_admin' => true, // Sesuaikan jika Anda menggunakan flag admin
        ]);

        $this->info('Admin user created successfully!');
    }
}

//php artisan make:seeder AdminSeeder
//php artisan create:filament-user
