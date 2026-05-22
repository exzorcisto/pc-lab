<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Вызываем созданные нами сидеры в строгом порядке
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ComponentSeeder::class,
            BuildTemplateSeeder::class,
        ]);
    }
}