<?php
namespace App\Http\Repositories\Product;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\ProductRatingRepositoryInterface;
use App\Models\Database;
use App\Models\ProductRating;
use PDO;

class ProductRatingRepository extends BaseRepository implements ProductRatingRepositoryInterface
{
    protected PDO $database;
    protected ProductRating $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new ProductRating();
        parent::__construct($this->model);
    }

    public function saveRatingProduct(array $payload): int
    {
        try {
            $data = array_intersect_key($payload, array_flip($this->model->fillAble()));
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $params = [];
            foreach ($data as $key => $value) {
                $params[":$key"] = $value;
            }

            $sql = "INSERT INTO {$this->model->getTable()} ($columns) VALUES ($placeholders)";
            return $this->insert($sql, $params);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getRatingByProductId(int $productId): array
    {
        try {
            $columns = implode(', ', ($this->model->getField()));
            $sql = "SELECT {$columns} FROM {$this->model->getTable()} as tb1 WHERE tb1.product_id = :product_id ORDER BY tb1.id DESC";
            return $this->get($sql, [':product_id' => $productId]);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}