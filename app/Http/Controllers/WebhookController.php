<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $verify_token = 'meatyhamhock'; // Mã xác minh bạn đã thiết lập

        // Kiểm tra mã xác minh từ yêu cầu
        if ($request->input('hub.verify_token') === $verify_token) {
            // Trả lại challenge để hoàn tất xác minh
            return response($request->input('hub.challenge'), 200);
        }

        // Nếu không khớp, trả về lỗi
        return response('Invalid verify_token', 403);
    }
}