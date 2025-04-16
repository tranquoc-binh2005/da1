<?php
namespace App\Http\Controllers\Dashboard\Order;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Services\Interfaces\Checkout\OrderServiceInterface as CheckoutOrderService;
use App\Http\Repositories\Interfaces\OrderStatusRepositoryInterface as OrderStatusRepository;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\ViewModel\frontend\HistoryViewModel;

class OrderController extends BaseController
{
    use Loggable, HasRender;
    protected CheckoutOrderService $orderService;
    protected OrderStatusRepository $orderStatusRepository;
    protected HistoryViewModel $historyViewModel;
    public function __construct(
        CheckoutOrderService $orderService,
        OrderStatusRepository $orderStatusRepository,
        HistoryViewModel $historyViewModel,
    )
    {
        $this->orderService = $orderService;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->historyViewModel = $historyViewModel;
        parent::__construct($orderService);
    }

    public function index()
    {
        try {
            $orders = $this->baseIndex();
            $status = $this->orderStatusRepository->allStatusOrder();
//            print_r($status); die();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'publish' => $_GET['publish'] ?? 1,
                'sort' => $_GET['sort'] ?? 1,
                'status_order_id' => $_GET['status_order_id'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', [
                'title' => "Quản lý đơn hàng",
                'body' => "order/index", 'orders' => $orders,
                'status' => $status,
            ]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function show(int $id = null): void
    {
        try {
            $order = $this->historyViewModel->getOrderDetailByOrderId($id);
//            print_r($order); die();
            $this->view('index', ['title' => "Hoá đơn điện tử", 'body' => "order/detail", 'order' => $order]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

}