<?php
namespace App\Http\Controllers\Frontend\Cart;

use App\Http\Controllers\Frontend\BaseController;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\ViewModel\frontend\ProductViewModel;
use App\ViewModel\frontend\CartItemViewModel;
class CartController extends BaseController
{
    use HasRender, Loggable;

    protected string $dataHeader;
    protected array $dataCart;
    protected CartItemViewModel $cartItemViewModel;
    protected ProductViewModel $productViewModel;

    public function __construct(
        CartItemViewModel $cartItemViewModel,
    )
    {
        parent::__construct();
        $this->cartItemViewModel = $cartItemViewModel;
    }

    public function index()
    {
        try {
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "cart/index",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
            ]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }
}