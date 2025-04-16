<?php
namespace App\ViewModel\frontend;

use App\Http\Repositories\Checkout\OrderRepository;
use App\Http\Repositories\Checkout\OrderDetailRepository;
use App\Http\Resources\History\HistoryResource;
use App\Models\Database;
class HistoryViewModel
{
    protected OrderRepository $orderRepository;
    protected OrderDetailRepository $orderDetailRepository;
    protected Database $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->orderRepository = new OrderRepository($this->database);
        $this->orderDetailRepository = new OrderDetailRepository($this->database);
    }

    /**
     * @throws \Exception
     */
    public function buildOrderByUserId(int $userId, ?int $status = null): array
    {
        try {
            $orders = $this->callOrderFindByUserId($userId, $status);
            return $this->buildDetailOrder($orders);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    private function callOrderFindByUserId(int $userId, ?int $status = null): array
    {
        $orders = $this->orderRepository->allOrderByUserId($userId, $status);
        $orders = new HistoryResource($orders);
        return $orders->toArray();
    }

    /**
     * @throws \Exception
     */
    private function buildDetailOrder(array $orders): array
    {
        foreach ($orders as &$order) {
            $order['detail'] = $this->orderDetailRepository->getDetailByOrderId($order['id']);
        }
        return $orders;
    }

    /**
     * @throws \Exception
     */
    public function getOrderDetailByOrderId(int $orderId): array
    {
        $order = $this->orderRepository->findOrderById($orderId);
        $order['detail'] = $this->orderDetailRepository->getDetailByOrderId($order['id']);
        return $order;
    }
}