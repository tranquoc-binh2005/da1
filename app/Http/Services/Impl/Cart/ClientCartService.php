<?php
namespace App\Http\Services\Impl\Cart;

use App\Http\Resources\Cart\CartItemResource;
use App\Traits\Loggable;
use App\Http\Repositories\Cart\CartItemRepository;
use App\Models\Database;
use App\Http\Services\Interfaces\Cart\ClientCartServiceInterface;
use App\ViewModel\frontend\CartItemViewModel;
use App\Http\Repositories\Product\ProductVariantRepository;

class ClientCartService implements ClientCartServiceInterface
{
    use Loggable;
    protected CartItemRepository $cartItemRepository;
    protected Database $database;
    protected CartItemViewModel $cartItemViewModel;
    protected ProductVariantRepository $productVariantRepository;

    public function __construct()
    {
        $this->database = new Database();
        $this->cartItemRepository = new CartItemRepository($this->database);
        $this->productVariantRepository = new ProductVariantRepository($this->database);
        $this->cartItemViewModel = new CartItemViewModel();
    }

    public function callCart(): array
    {
        try {
            $userId  = $_SESSION['user']['id'] ?? null;

            if(!$userId) return [];

            $cart = $this->cartItemRepository->getCartItem($userId);
            $cart = new CartItemResource($cart);
            return $this->buildCartItem($cart->toArray());
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function clearCart(): bool
    {
        try {
            $userId  = $_SESSION['user']['id'] ?? null;

            if(!$userId) return false;

            return $this->cartItemRepository->clearCart($userId);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    private function buildCartItem(array $carts): array
    {
        try {
            return $this->cartItemViewModel->getProductItem($carts);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }
}