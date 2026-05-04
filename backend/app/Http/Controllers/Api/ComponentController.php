<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * Получение списка компонентов с фильтрацией.
     */
    public function index(Request $request)
    {
        // Начинаем запрос с подгрузкой категории для каждого товара
        $query = Component::query()->with('category');

        // Фильтр по ID категории (например, 1 для CPU, 2 для Motherboards)
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Фильтр по сокету (для совместимости процессора и платы)
        if ($request->has('socket')) {
            $query->where('socket', $request->socket);
        }

        // Фильтр по типу RAM (DDR4 / DDR5)
        if ($request->has('ram_type')) {
            $query->where('ram_type', $request->ram_type);
        }

        // Получаем только доступные товары
        $components = $query->where('is_available', true)->get();

        return response()->json($components);
    }

    /**
     * Получение детальной информации об одном компоненте.
     */
    public function show($id)
    {
        $component = Component::with('category')->find($id);

        if (!$component) {
            return response()->json(['message' => 'Компонент не найден'], 404);
        }

        return response()->json($component);
    }
}