<?php
namespace App\Http\Repositories\Checkout;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Models\Database;
use App\Models\OrderStatus;
use PDO;
use PDOException;

class OrderStatusRepository extends BaseRepository implements OrderStatusRepositoryInterface
{
    protected PDO $database;
    protected OrderStatus $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new OrderStatus();
        parent::__construct($this->model);
    }

    public function allStatusOrder(): array
    {
        try {
            $sql = "SELECT * FROM {$this->model->getTable()}";
            return $this->get($sql);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}