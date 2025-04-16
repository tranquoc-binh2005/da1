<?php
namespace App\Http\Repositories\Checkout;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Models\Database;
use App\Models\OrderDetail;
use PDO;

class OrderDetailRepository extends BaseRepository implements OrderDetailRepositoryInterface
{
    protected PDO $database;
    protected OrderDetail $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new OrderDetail();
        parent::__construct($this->model);
    }

    /**
     * @throws \Exception
     */
    public function createDetailOrder(?int $orderId = null, array $payloadDetail = []): bool
    {
        try{
            if (empty($orderId)) {
                echo "Product ID is required"; die();
            }

            foreach ($payloadDetail as $value) {
                $sql = "INSERT INTO {$this->model->getTable()} (product_id, product_variant_id, quantity, price, order_id) 
                             VALUES (:product_id, :product_variant_id, :quantity, :price, :order_id)";
                $params = [
                    ':product_id' => $value['product_id'],
                    ':product_variant_id' => $value['product_variant_id'],
                    ':quantity' => $value['quantity'],
                    ':price' => $value['price'],
                    ':order_id' => $value['order_id'],
                ];
                $this->insert($sql, $params);
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getDetailByOrderId(int $orderId): ?array
    {
        try {
            $columns = implode(', ', array_merge(
                $this->model->getField(),
                $this->model->getFieldJoin()
            ));
            $sql = "SELECT $columns
                FROM {$this->model->getTable()} AS tb1
                LEFT JOIN products AS tb2 ON tb1.product_id = tb2.id
                LEFT JOIN product_variants AS tb3 ON tb1.product_variant_id = tb3.id
                LEFT JOIN unit_products AS tb4 ON tb3.unit_id = tb4.id
                WHERE tb1.order_id = :order_id";
            return $this->get($sql, [":order_id" => $orderId]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByProductId(int $orderId)
    {
        try {
            $sql = "SELECT 
                    tb1.*, 
                    tb2.value AS unit_value, 
                    tb2.unit AS unit_name
                FROM {$this->model->getTable()} AS tb1
                LEFT JOIN unit_products AS tb2 ON tb1.unit_id = tb2.id
                WHERE tb1.product_id = :product_id";

            return $this->get($sql, [":product_id" => $orderId]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

}