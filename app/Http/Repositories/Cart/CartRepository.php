<?php
namespace App\Http\Repositories\Cart;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\CartRepositoryInterface;
use App\Models\Database;
use App\Models\Cart;
use PDO;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected PDO $database;
    protected Cart $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Cart();
        parent::__construct($this->model);
    }

    public function createCart(int $user_id): int
    {
        try {
            $sqlCheck = "SELECT id FROM carts WHERE user_id = :user_id LIMIT 1";
            $cart = $this->find($sqlCheck, ['user_id' => $user_id]);

            if (!empty($cart)) {
                return (int)$cart['id'];
            }

            $sqlInsert = "INSERT INTO carts (user_id) VALUES (:user_id)";
            return $this->insert($sqlInsert, ['user_id' => $user_id]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCart(int $user_id): array
    {
        try {
            $sql = "SELECT * FROM carts WHERE user_id = :user_id LIMIT 1";
            $cart = $this->find($sql, ['user_id' => $user_id]);
            return $cart ?? [];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}