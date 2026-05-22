<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildTemplate;
use App\Models\BuildTemplateItem;

class BuildTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CORE BASE
        $t1 = BuildTemplate::create(['name' => 'CORE BASE', 'category' => 'CORE', 'description' => 'Начальный уровень для офиса и игр']);
        $this->attachComponents($t1->id, [1, 5, 7, 9, 13]); // Процессор, Мать, ОЗУ, Видео, БП

        // 2. CORE PRO
        $t2 = BuildTemplate::create(['name' => 'CORE PRO', 'category' => 'CORE', 'description' => 'Для комфортных игр']);
        $this->attachComponents($t2->id, [2, 5, 7, 10, 14]);

        // 3. QUANTUM ULTRA
        $t3 = BuildTemplate::create(['name' => 'QUANTUM ULTRA', 'category' => 'QUANTUM', 'description' => 'Бескомпромиссная мощь']);
        $this->attachComponents($t3->id, [4, 6, 8, 12, 15]);
    }

    private function attachComponents(int $templateId, array $componentIds)
    {
        foreach ($componentIds as $componentId) {
            BuildTemplateItem::create([
                'template_id' => $templateId,
                'component_id' => $componentId,
                'quantity' => 1
            ]);
        }
    }
}