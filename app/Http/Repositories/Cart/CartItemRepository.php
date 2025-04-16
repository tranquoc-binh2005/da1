<?php
namespace App\Http\Repositories\Cart;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\CartItemRepositoryInterface;
use App\Models\Database;
use App\Models\CartItem;
use PDO;
use App\Http\Repositories\Cart\CartRepository;

class CartItemRepository extends BaseRepository implements CartItemRepositoryInterface
{
    protected PDO $database;
    protected CartItem $model;
    protected CartRepository $cartRepository;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new CartItem();
        $this->cartRepository = new CartRepository($this->database);
        parent::__construct($this->model);
    }

    public function insertCartItem(array $data): int
    {
        try {
            $columns = implode(', ', $this->model->fillAble());
            $placeholders = ':' . implode(', :', $this->model->fillAble());

            $sql = "INSERT INTO {$this->model->getTable()} ({$columns}) 
                VALUES ({$placeholders}) 
                ON DUPLICATE KEY UPDATE 
                quantity = quantity + :quantity, total_price = total_price + :total_price";

            return $this->insert($sql, [
                ':cart_id' => $data['cart_id'],
                ':product_id' => $data['product_id'],
                ':product_variant_id' => $data['product_variant_id'],
                ':quantity' => $data['quantity'],
                ':total_price' => $data['total_price'],
                ':unit' => $data['unit'],
                ':price' => $data['price'],
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getCartItem(int $userId): array
    {
        try {
            $cart = $this->getCart($userId);
            if(!$cart) return [];
            $sql = "SELECT * FROM cart_items WHERE cart_id = :cart_id";
            return $this->get($sql, [':cart_id' => $cart['id']]);
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function getCart(int $userId): array
    {
        return $this->cartRepository->getCart($userId);
    }

    public function getTotalCart(int $cartId): array
    {
        try {
            $sql = "SELECT SUM(total_price) AS total
                FROM cart_items
                WHERE cart_id = :cart_id";
            return $this->find($sql, [':cart_id' => $cartId]);
        } catch (\Exception $e){
            throw $e;
        }
    }
    public function updateCart(array $payload): int
    {
        try {
            $sql = "UPDATE cart_items 
                    SET quantity = :quantity, 
                        total_price = :total_price 
                    WHERE id = :id";
            return $this->execute($sql, [
                ':id' => $payload['id'],
                ':quantity' => $payload['quantity'],
                ':total_price' => $payload['price'] * $payload['quantity'],
            ]);
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function removeCart(int $id): bool
    {
        try {
            $sql = "DELETE FROM cart_items WHERE id = :id";
            return $this->execute($sql, [':id' => $id]);
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function clearCart(int $userId): bool
    {
        try {
            $cardId = $this->getCart($userId)['id'];
            $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id";
            return $this->execute($sql, [':cart_id' => $cardId]);
        } catch (\Exception $e){
            throw $e;
        }
    }
}