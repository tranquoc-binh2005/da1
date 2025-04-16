<?php
namespace App\Http\Repositories\Dashboard;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\DashboardBuilderRepositoryInterface;
use App\Models\Database;
use App\Models\Order;
use PDO;

class DashboardBuilderRepository extends BaseRepository implements DashboardBuilderRepositoryInterface
{
    protected PDO $database;
    protected Order $model;
    public function __construct()
    {
        $this->database = Database::connection();
        parent::__construct($this->database);
    }

    public function getCustomerByMonth(int $month): int|array
    {
        try {
            $startDate = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));

            $sql = "SELECT COUNT(*) AS newCustomers
                FROM users
                WHERE created_at BETWEEN :startDate AND :endDate";

            return $this->find($sql, [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ]) ?? 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getTotalPriceByMonth(int $month): int|array
    {
        try {
            $startDate = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));

            $sql = "SELECT SUM(total_price) AS totalPrices
                FROM orders
                WHERE created_at BETWEEN :startDate AND :endDate";

            return $this->find($sql, [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ]) ?? 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getTotalPriceOfCurrentWeek(): int|array
    {
        try {
            // Lấy thứ 2 đầu tuần (00:00:00)
            $startDate = date('Y-m-d 00:00:00', strtotime('monday this week'));

            // Lấy chủ nhật cuối tuần (23:59:59)
            $endDate = date('Y-m-d 23:59:59', strtotime('sunday this week'));

            $sql = "SELECT SUM(total_price) AS totalPrices
                FROM orders
                WHERE created_at BETWEEN :startDate AND :endDate";

            return $this->find($sql, [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ]) ?? 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getTotalPriceByQuarter(int $quarter): int|array
    {
        try {
            // Xác định tháng bắt đầu và kết thúc của quý
            $startMonth = ($quarter - 1) * 3 + 1;
            $endMonth = $startMonth + 2;

            $year = date('Y');
            $startDate = "{$year}-" . str_pad($startMonth, 2, '0', STR_PAD_LEFT) . "-01";
            $endDate = date('Y-m-t', strtotime("{$year}-" . str_pad($endMonth, 2, '0', STR_PAD_LEFT) . "-01"));

            $sql = "SELECT SUM(total_price) AS totalPrices
                FROM orders
                WHERE created_at BETWEEN :startDate AND :endDate";

            return $this->find($sql, [
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ]) ?? 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }



    public function getOrdersByMonth(int $month, int $statusId): int|array
    {
        try {
            $startDate = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));

            $sql = "SELECT COUNT(*) AS newOrders
                FROM orders
                WHERE created_at BETWEEN :startDate AND :endDate AND status_order_id = :status_order_id";

            return $this->find($sql, [
                ':startDate' => $startDate,
                ':endDate' => $endDate,
                ':status_order_id' => $statusId
            ]) ?? 0;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}