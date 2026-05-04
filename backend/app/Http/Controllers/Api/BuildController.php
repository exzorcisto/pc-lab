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
    public function store(Request $request)
    {
        $request->validate([
            'components' => 'required|array', // Массив ID компонентов
            'components.*' => 'exists:components,id' // Каждый ID должен быть в базе
        ]);

        return DB::transaction(function () use ($request) {
            // Считаем общую стоимость сборки
            $totalPrice = Component::whereIn('id', $request->components)->sum('price');

            // Создаем запись о сборке
            $build = SavedBuild::create([
                'user_id' => auth()->id(), // null если гость
                'share_hash' => Str::random(12), // Уникальный код для ссылки
                'total_price' => $totalPrice
            ]);

            // Привязываем компоненты к сборке
            foreach ($request->components as $componentId) {
                SavedBuildItem::create([
                    'saved_build_id' => $build->id,
                    'component_id' => $componentId,
                    'quantity' => 1
                ]);
            }

            return response()->json([
                'message' => 'Сборка сохранена!',
                'share_url' => url("/api/builds/{$build->share_hash}"),
                'total_price' => $totalPrice
            ], 201);
        });
    }

    public function show($hash)
    {
        // Получаем сборку по хэшу вместе с компонентами и их категориями
        $build = SavedBuild::where('share_hash', $hash)
            ->with('items.component.category')
            ->first();

        if (!$build) {
            return response()->json(['message' => 'Сборка не найдена'], 404);
        }

        return response()->json($build);
    }
}