<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Создаем Админа
    User::create([
        'name' => 'Admin PC Lab',
        'email' => 'admin@pclab.ru',
        'phone' => '79991112233',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);

    // Создаем обычного Пользователя
    User::create([
        'name' => 'Иван Иванов Иванович',
        'email' => 'user@mail.ru',
        'phone' => '79005554433',
        'password' => Hash::make('user123'),
        'role' => 'user',
    ]);
}
}
