<?php
namespace App\Http\Controllers\Frontend\About;

use App\Http\Controllers\Frontend\BaseController;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\ViewModel\frontend\CartItemViewModel;
use App\Http\Repositories\Interfaces\OrderStatusRepositoryInterface as OrderStatusRepository;
use App\ViewModel\frontend\HistoryViewModel;

class AboutController extends BaseController
{
    use HasRender, Loggable;

    protected string $dataHeader;
    protected array $dataCart;
    protected CartItemViewModel $cartItemViewModel;
    protected HistoryViewModel $historyViewModel;
    protected OrderStatusRepository $orderStatusRepository;

    public function __construct
    (
        CartItemViewModel $cartItemViewModel,
        OrderStatusRepository $orderStatusRepository,
        HistoryViewModel $historyViewModel,
    )
    {
        parent::__construct();
        $this->cartItemViewModel = $cartItemViewModel;
        $this->historyViewModel = $historyViewModel;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    public function about(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "about/index",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ]
            ]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    /**
     * @throws \Exception
     */
    private function callOrderStatus(): array
    {
        return $this->orderStatusRepository->allStatusOrder();
    }

    /**
     * @throws \Exception
     */
    private function callOrder(): array
    {
        $userId = $_SESSION['user']['id'];
        return $this->historyViewModel->buildOrderByUserId($userId);
    }

    public function detail(?int $id = null)
    {
        try {
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "history/detail",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'dataDetailOrder' => $this->historyViewModel->getOrderDetailByOrderId($id)
            ]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }
}