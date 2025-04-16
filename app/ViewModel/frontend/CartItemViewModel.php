<?php
namespace App\ViewModel\frontend;

use App\Http\Repositories\Product\ProductRepository;
use App\Models\Database;
use App\Http\Resources\Cart\DetailCartItemResource;
class CartItemViewModel
{
    protected ProductRepository $productRepository;
    protected Database $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->productRepository = new ProductRepository($this->database);
    }

    public function getProductItem(array $carts): array
    {
        try {
            $total = 0;
            foreach ($carts as &$cart) {
                $productItem = $this->productRepository->findById($cart['product_id']);
                $productItem = new DetailCartItemResource($productItem);
                $cart['productItem'] = $productItem->toArray();
                $total += $cart['price'] * $cart['quantity'];
            }
            return $carts;
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function totalCart(array $carts): float|int
    {
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['price'] * $cart['quantity'];
        }
        return $total;
    }
}
