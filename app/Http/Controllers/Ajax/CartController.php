<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Repositories\Interfaces\CartItemRepositoryInterface as CartItemRepository;
use App\Http\Repositories\Interfaces\CartRepositoryInterface as CartRepository;
use App\Http\Services\Interfaces\Cart\ClientCartServiceInterface as ClientCartService;
use App\Http\Controllers\Ajax\BaseAjaxController;
class CartController extends BaseAjaxController
{
    protected CartRepository $cartRepository;
    protected CartItemRepository $cartItemRepository;
    protected ClientCartService $clientCartService;
    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        ClientCartService $clientCartService,
    )
    {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->clientCartService = $clientCartService;
    }

    /**
     * @throws \Exception
     */
    public function addCart(): void
    {
        header('Content-Type: application/json');
        try {
            $user = $this->isLogin();
            if (!$user) {
                echo json_encode(['status' => false, 'message' => "Vui lòng đăng nhập để tiếp tục"]);
                return;
            }

            $payload = [
                'productId' => $_POST['data']['productId'],
                'productVariantId' => $_POST['data']['productVariantId'],
                'unit' => $_POST['data']['unit'],
                'quantity' => $_POST['data']['quantity'],
                'price' => $_POST['data']['price'],
                'user_id' => $user['id'],
            ];
            $data = $this->prepareData($payload);
            $this->cartItemRepository->insertCartItem($data);
            $countCart = $this->cartItemRepository->getCartItem($user['id']);
            echo json_encode(['status' => true, 'message' => "Thêm sản phẩm vào giỏ hàng thành công", 'countCart' => $countCart]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @throws \Exception
     */
    private function prepareData(array $data): array
    {
        $cartId = $this->cartRepository->createCart($data['user_id']);
        return [
            'cart_id' => $cartId,
            'product_id' => $data['productId'],
            'product_variant_id' => $data['productVariantId'],
            'unit' => $data['unit'],
            'quantity' => $data['quantity'],
            'total_price' => $data['price'] * $data['quantity'],
            'price' => $data['price'],
        ];
    }

    public function updateCart(): void
    {
        header('Content-Type: application/json');
        try {
            $user = $this->isLogin();
            $payload = [
                'id' => $_POST['data']['id'],
                'quantity' => $_POST['data']['quantity'],
                'price' => $_POST['data']['price'],
            ];
            $this->cartItemRepository->updateCart($payload);
            $totalCart = $this->getTotalCart($user['id']);
            echo json_encode(['status' => true, 'message' => "Cập nhật giỏ hàng thành công", 'total' => $totalCart['total']]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function removeCart(): void
    {
        header('Content-Type: application/json');
        try {
            $user = $this->isLogin();
            $cartItemId = $_POST['cartId'];

            if(!$this->cartItemRepository->removeCart($cartItemId)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra vui lòng thử lại"]);
                die();
            }
            $cart = $this->clientCartService->callCart();
            $totalCart = $this->getTotalCart($user['id']);
            echo json_encode([
                'status' => true,
                'message' => "Cập nhật giỏ hàng thành công",
                'cart' => $cart,
                'totalCart' => $totalCart['total'],
            ]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @throws \Exception
     */
    private function getTotalCart(int $userId): array
    {
        $cart = $this->cartItemRepository->getCart($userId);
        return $this->cartItemRepository->getTotalCart($cart['id']);
    }
}