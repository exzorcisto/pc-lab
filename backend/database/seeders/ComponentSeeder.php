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
        $components = [
            // ПРОЦЕССОРЫ (category_id: 1)
            [
                'category_id' => 1,
                'name' => 'Intel Core i9-14900K',
                'price' => 55000,
                'socket' => 'LGA1700',
                'ram_type' => 'DDR5',
                'tdp' => 125,
                'is_available' => true,
                'performance_index' => 95,
            ],
            [
                'category_id' => 1,
                'name' => 'AMD Ryzen 5 5600X',
                'price' => 15000,
                'socket' => 'AM4',
                'ram_type' => 'DDR4',
                'tdp' => 65,
                'is_available' => true,
                'performance_index' => 70,
            ],

            // МАТЕРИНСКИЕ ПЛАТЫ (category_id: 2)
            [
                'category_id' => 2,
                'name' => 'ASUS ROG STRIX Z790-E',
                'price' => 45000,
                'socket' => 'LGA1700',
                'ram_type' => 'DDR5',
                'form_factor' => 'ATX',
                'is_available' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Gigabyte B550 AORUS ELITE',
                'price' => 12000,
                'socket' => 'AM4',
                'ram_type' => 'DDR4',
                'form_factor' => 'ATX',
                'is_available' => true,
            ],

            // ОПЕРАТИВНАЯ ПАМЯТЬ (category_id: 3)
            [
                'category_id' => 3,
                'name' => 'Kingston FURY Beast 32GB DDR5',
                'price' => 14000,
                'ram_type' => 'DDR5',
                'is_available' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Corsair Vengeance LPX 16GB DDR4',
                'price' => 5000,
                'ram_type' => 'DDR4',
                'is_available' => true,
            ],

            // ВИДЕОКАРТЫ (category_id: 4)
            [
                'category_id' => 4,
                'name' => 'NVIDIA RTX 4090',
                'price' => 200000,
                'tdp' => 450,
                'is_available' => true,
                'performance_index' => 100,
            ],
            [
                'category_id' => 4,
                'name' => 'NVIDIA RTX 3060',
                'price' => 35000,
                'tdp' => 170,
                'is_available' => true,
                'performance_index' => 65,
            ],

            // БЛОКИ ПИТАНИЯ (category_id: 5 - ИСПРАВЛЕНО)
            [
                'category_id' => 5,
                'name' => 'Be Quiet! Straight Power 11 1000W',
                'price' => 18000,
                'power' => 1000,
                'is_available' => true,
            ],
            [
                'category_id' => 5,
                'name' => 'Deepcool DN450 450W',
                'price' => 3000,
                'power' => 450,
                'is_available' => true,
            ],
        ];

        foreach ($components as $component) {
            \App\Models\Component::create($component);
        }
    }
}