<?php
namespace App\Http\Controllers\Ajax;

use App\ViewModel\frontend\HistoryViewModel;
use App\Http\Controllers\Ajax\BaseAjaxController;
class HistoryController extends BaseAjaxController
{
    protected HistoryViewModel $historyViewModel;
    public function __construct(
        HistoryViewModel $historyViewModel
    )
    {
        $this->historyViewModel = $historyViewModel;
    }

    public function callHistoryOrderByStatus(): void
    {
        try {
            header('Content-Type: application/json');
            $user = $this->isLogin();
            $statusId = $_POST['statusId'] ?? null;
            $orders = $this->historyViewModel->buildOrderByUserId($user['id'], $statusId);
            echo json_encode(['status' => true, 'message' => 'success', 'data' => $orders]);
        } catch (\Exception $exception){
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}