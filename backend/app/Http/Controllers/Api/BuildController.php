<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SavedBuild;
use App\Models\SavedBuildItem;
use App\Models\Component;
use App\Models\BuildTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BuildController extends Controller
{
    /**
     * Сохранение новой кастомной сборки.
     */
    public function store(Request $request)
    {
        $request->validate([
            'components' => 'required|array',
            'components.*' => 'exists:components,id'
        ]);

        $components = Component::whereIn('id', $request->components)->get();

        // 1. Валидация БП
        $totalTdp = $components->sum('tdp') + 50;
        $psu = $components->firstWhere('category_id', 5); 

        if ($psu && $psu->power > 0) {
            $effectivePower = $psu->power * 0.8;
            if ($totalTdp > $effectivePower) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'power_incompatibility',
                    'message' => "Недостаточная мощность БП."
                ], 422);
            }
        }

        return DB::transaction(function () use ($request, $components) {
            $totalPrice = $components->sum('price');

            $build = SavedBuild::create([
                'user_id' => auth()->id(),
                'name' => '#C-' . Str::upper(Str::random(8)),
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

            return response()->json(['status' => 'success', 'build_id' => $build->id], 201);
        });
    }

    /**
     * Обновление (конфигурация) существующей сборки.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'components' => 'required|array',
            'components.*' => 'exists:components,id',
        ]);

        $build = SavedBuild::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return DB::transaction(function () use ($request, $build) {
            // Удаляем старые компоненты
            SavedBuildItem::where('saved_build_id', $build->id)->delete();

            // Добавляем новые
            $components = Component::whereIn('id', $request->components)->get();
            foreach ($request->components as $componentId) {
                SavedBuildItem::create([
                    'saved_build_id' => $build->id,
                    'component_id' => $componentId,
                    'quantity' => 1
                ]);
            }

            // Пересчитываем цену
            $build->update(['total_price' => $components->sum('price')]);

            return response()->json([
                'status' => 'success',
                'message' => 'Сборка успешно обновлена',
                'is_modified' => $build->is_modified
            ]);
        });
    }

    /**
     * Копирование шаблона в SavedBuild.
     */
    public function storeFromTemplate(Request $request, $templateId)
    {
        $template = BuildTemplate::with('items.component')->findOrFail($templateId);

        return DB::transaction(function () use ($template) {
            $build = SavedBuild::create([
                'user_id' => auth()->id(),
                'name' => $template->name,
                'template_id' => $template->id,
                'share_hash' => Str::random(12),
                'total_price' => $template->items->sum(fn($item) => $item->component->price)
            ]);

            foreach ($template->items as $item) {
                SavedBuildItem::create([
                    'saved_build_id' => $build->id,
                    'component_id' => $item->component_id,
                    'quantity' => $item->quantity
                ]);
            }

            return response()->json(['status' => 'success', 'build_id' => $build->id], 201);
        });
    }

    public function show($hash)
    {
        return SavedBuild::where('share_hash', $hash)
            ->with(['items.component.category'])
            ->firstOrFail();
    }

    public function index()
    {
        return response()->json([
            'status' => 'success', 
            'data' => SavedBuild::where('user_id', auth()->id())->withCount('items')->get()
        ]);
    }
}