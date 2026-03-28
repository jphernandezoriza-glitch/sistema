<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@uptex.edu.mx'],
            [
                'name'     => 'Administrador UPTex',
                'password' => Hash::make('12345678'),
                'rol'      => 'admin',
            ]
        );
    }
}