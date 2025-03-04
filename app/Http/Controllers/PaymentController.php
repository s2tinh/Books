<?php

namespace App\Http\Controllers;

use App\Services\SePayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $sePayService;

    // Inject SePayService vào controller
    public function __construct(SePayService $sePayService)
    {
        $this->sePayService = $sePayService;
    }

    // Hàm kiểm tra thanh toán
    public function checkPayment($transactionId)
    {
        // Gọi service để kiểm tra trạng thái giao dịch
        $transaction = $this->sePayService->checkTransaction($transactionId);

        // Kiểm tra trạng thái giao dịch
        if ($transaction['status'] === 'success') {
            return response()->json(['message' => 'Thanh toán thành công']);
        } else {
            return response()->json(['message' => 'Thanh toán chưa hoàn tất'], 400);
        }
    }
}
