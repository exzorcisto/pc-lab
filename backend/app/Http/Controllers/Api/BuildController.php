<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SavedBuild;
use App\Models\SavedBuildItem;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BuildController extends Controller
{
    /**
     * Сохранение новой сборки с проверкой совместимости.
     */
    public function store(Request $request)
    {
        // Базовая валидация входящих данных
        $request->validate([
            'components' => 'required|array',
            'components.*' => 'exists:components,id'
        ]);

        // Извлекаем все выбранные компоненты из базы
        $components = Component::whereIn('id', $request->components)->get();

        // --- ЛОГИКА ВАЛИДАЦИИ СОВМЕСТИМОСТИ ---

        // 1. Проверка мощности БП (Категория 5)
        $totalTdp = $components->sum('tdp') + 50; // Сумма TDP + запас на систему
        $psu = $components->firstWhere('category_id', 5); 

        if ($psu && $psu->power > 0) {
            $effectivePower = $psu->power * 0.8; // Запас надежности 20%
            
            if ($totalTdp > $effectivePower) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'power_incompatibility',
                    'message' => "Недостаточная мощность БП. Системе нужно ~{$totalTdp}W, а ваш БП выдает эффективных {$effectivePower}W."
                ], 422);
            }
        }

        // 2. Проверка типа оперативной памяти (DDR4 vs DDR5)
        $motherboard = $components->firstWhere('category_id', 2); // 2 - Материнские платы
        $ram = $components->firstWhere('category_id', 3);         // 3 - ОЗУ

        if ($motherboard && $ram) {
            if ($motherboard->ram_type !== $ram->ram_type) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'ram_incompatibility',
                    'message' => "Конфликт поколений памяти. Плата поддерживает {$motherboard->ram_type}, а выбрана планка {$ram->ram_type}."
                ], 422);
            }
        }

        // --- СОХРАНЕНИЕ В БАЗУ ДАННЫХ ---

        return DB::transaction(function () use ($request, $components, $totalTdp, $psu) {
            $totalPrice = $components->sum('price');

            $build = SavedBuild::create([
                'user_id' => auth()->id(), // null для гостей
                'share_hash' => Str::random(12),
                'total_price' => $totalPrice
            ]);

            foreach ($request->components as $componentId) {
                SavedBuildItem::create([
                    'saved_build_id' => $build->id,
                    'component_id' => $componentId,
                    'quantity' => 1
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Сборка успешно прошла проверку и сохранена!',
                'share_hash' => $build->share_hash,
                'total_price' => $totalPrice,
                'details' => [
                    'estimated_tdp' => $totalTdp,
                    'psu_limit' => $psu ? $psu->power * 0.8 : 'N/A'
                ]
            ], 201);
        });
    }

    /**
     * Просмотр сборки по хэшу (публично).
     */
    public function show($hash)
    {
        $build = SavedBuild::where('share_hash', $hash)
            ->with(['items.component.category'])
            ->first();

        if (!$build) {
            return response()->json(['message' => 'Сборка не найдена'], 404);
        }

        return response()->json($build);
    }

    /**
     * Получение списка всех сборок текущего пользователя.
    */
    public function index()
    {
        // Берем только сборки авторизованного пользователя
        $builds = SavedBuild::where('user_id', auth()->id())
            ->withCount('items') // Посчитаем кол-во деталей
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $builds
        ]);
    }
}