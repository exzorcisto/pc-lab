<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Component;
use App\Models\Category;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Находим ID категорий, которые мы создали в CategorySeeder
        $cpuCategory = Category::where('name', 'Processors')->first();
        $mbCategory = Category::where('name', 'Motherboards')->first();

        if ($cpuCategory && $mbCategory) {
            // Добавляем процессор
            Component::create([
                'category_id' => $cpuCategory->id,
                'name' => 'Intel Core i5-13400F',
                'price' => 21000.00,
                'socket' => 'LGA1700',
                'ram_type' => 'DDR5',
                'tdp' => 65,
                'is_available' => true
            ]);

            // Добавляем материнскую плату
            Component::create([
                'category_id' => $mbCategory->id,
                'name' => 'ASUS ROG STRIX B760-I',
                'price' => 18500.00,
                'socket' => 'LGA1700',
                'ram_type' => 'DDR5',
                'form_factor' => 'mini-ITX',
                'is_available' => true
            ]);
        }
    }
}