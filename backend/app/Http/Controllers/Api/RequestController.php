<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallbackRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    // --- Заявки на обратный звонок ---

    public function storeCallback(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        CallbackRequest::create($data);
        return response()->json(['message' => 'Заявка принята, мы свяжемся с вами!'], 201);
    }

    public function indexCallback()
    {
        return CallbackRequest::latest()->get();
    }

    public function updateCallbackStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
        ]);

        $callback = CallbackRequest::findOrFail($id);
        $callback->update(['status' => $request->status]);

        return response()->json(['message' => 'Статус заявки на звонок обновлен']);
    }

    // --- Заявки на услуги ---

    public function storeService(Request $request)
    {
        $request->validate([
            'service_type' => 'required|in:upgrade,maintenance,partnership',
            'preferred_time' => 'required|string',
            'comment' => 'nullable|string|max:1000',
        ]);

        ServiceRequest::create([
            'user_id' => auth()->id(),
            'service_type' => $request->service_type,
            'preferred_time' => $request->preferred_time,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Заявка на услугу успешно создана!'], 201);
    }

    public function indexService()
    {
        return ServiceRequest::with('user:id,name,phone')->latest()->get();
    }

    public function updateService(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,awaiting_payment,resolved,cancelled',
            'price' => 'nullable|numeric|min:0',
            'admin_note' => 'nullable|string',
        ]);

        $service = ServiceRequest::findOrFail($id);
        $service->update($request->only(['status', 'price', 'admin_note']));

        return response()->json(['message' => 'Заявка обновлена']);
    }
}