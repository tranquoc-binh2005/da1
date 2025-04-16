<?php
namespace App\Http\Repositories\Checkout;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\OrderRepositoryInterface;
use App\Models\Database;
use App\Models\Order;
use PDO;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected PDO $database;
    protected Order $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Order();
        parent::__construct($this->model);
    }

    public function allOrderByUserId(int $userId, ?int $status = null): array
    {
        try {
            $columns = implode(', ', array_merge(
                $this->model->getField(),
                $this->model->getFieldJoin()
            ));

            $sql = "SELECT $columns FROM {$this->model->getTable()} as tb1
                JOIN status_orders as tb2 ON tb1.status_order_id = tb2.value
                JOIN address_shoppings as tb3 ON tb1.address_shopping_id = tb3.id
                WHERE tb1.user_id = :user_id";

            $params = [':user_id' => $userId];

            if (!is_null($status)) {
                $sql .= " AND tb1.status_order_id = :status";
                $params[':status'] = $status;
            }

            $sql .= " ORDER BY tb1.id DESC";

            return $this->get($sql, $params);
        } catch (\Exception $exception){
            throw $exception;
        }
    }

    public function findOrderById(int $orderId): array
    {
        try {
            $columns = implode(', ', array_merge(
                $this->model->getField(),
                $this->model->getFieldJoin()
            ));

            $sql = "SELECT $columns FROM {$this->model->getTable()} as tb1
                JOIN status_orders as tb2 ON tb1.status_order_id = tb2.value
                JOIN address_shoppings as tb3 ON tb1.address_shopping_id = tb3.id
                WHERE tb1.id = :id LIMIT 1";

            $params = [':id' => $orderId];

            return $this->find($sql, $params);
        } catch (\Exception $exception){
            throw $exception;
        }
    }

    public function changeStatusOrder($data): int
    {
        try {
            $sql = "UPDATE orders SET status_order_id = :status WHERE id = :id";
            $params = [':id' => $data['id'], ':status' => $data['status']];
            return $this->execute($sql, $params);
        } catch (\Exception $exception){
            throw $exception;
        }
    }

}