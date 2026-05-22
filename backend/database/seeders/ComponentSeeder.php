<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        $components = [
            // 1. ПРОЦЕССОРЫ
            ['category_id' => 1, 'name' => 'Intel Core i3-12100F', 'price' => 9500, 'socket' => 'LGA1700', 'ram_type' => 'DDR4', 'tdp' => 58, 'is_available' => true],
            ['category_id' => 1, 'name' => 'Intel Core i5-12400F', 'price' => 13500, 'socket' => 'LGA1700', 'ram_type' => 'DDR4', 'tdp' => 65, 'is_available' => true],
            ['category_id' => 1, 'name' => 'Intel Core i5-13400F', 'price' => 18500, 'socket' => 'LGA1700', 'ram_type' => 'DDR5', 'tdp' => 65, 'is_available' => true],
            ['category_id' => 1, 'name' => 'Intel Core i5-13700KF', 'price' => 33000, 'socket' => 'LGA1700', 'ram_type' => 'DDR5', 'tdp' => 125, 'is_available' => true],

            // 2. МАТЕРИНСКИЕ ПЛАТЫ
            ['category_id' => 2, 'name' => 'MSI PRO H610M-E (DDR4)', 'price' => 8500, 'socket' => 'LGA1700', 'ram_type' => 'DDR4', 'form_factor' => 'mATX', 'is_available' => true],
            ['category_id' => 2, 'name' => 'ASUS PRIME B760-PLUS (DDR5)', 'price' => 16000, 'socket' => 'LGA1700', 'ram_type' => 'DDR5', 'form_factor' => 'ATX', 'is_available' => true],

            // 3. ОПЕРАТИВНАЯ ПАМЯТЬ
            ['category_id' => 3, 'name' => '16GB DDR4 Kingston FURY', 'price' => 4500, 'ram_type' => 'DDR4', 'is_available' => true],
            ['category_id' => 3, 'name' => '32GB DDR5 Kingston FURY', 'price' => 12000, 'ram_type' => 'DDR5', 'is_available' => true],

            // 4. ВИДЕОКАРТЫ
            ['category_id' => 4, 'name' => 'Palit RTX 5050 Dual', 'price' => 29000, 'tdp' => 100, 'is_available' => true],
            ['category_id' => 4, 'name' => 'Palit RTX 5060 Dual', 'price' => 40000, 'tdp' => 130, 'is_available' => true],
            ['category_id' => 4, 'name' => 'MSI RTX 5070 Dual', 'price' => 68000, 'tdp' => 200, 'is_available' => true],
            ['category_id' => 4, 'name' => 'ASUS ROG RTX 5080 Dual', 'price' => 98000, 'tdp' => 300, 'is_available' => true],

            // 5. БЛОКИ ПИТАНИЯ
            ['category_id' => 5, 'name' => 'Deepcool PF500 500W', 'price' => 4000, 'power' => 500, 'is_available' => true],
            ['category_id' => 5, 'name' => 'Deepcool PK650D 650W', 'price' => 6500, 'power' => 650, 'is_available' => true],
            ['category_id' => 5, 'name' => 'Be Quiet! System Power 10 850W', 'price' => 11000, 'power' => 850, 'is_available' => true],
        ];

        foreach ($components as $component) {
            Component::create($component);
        }
    }
}