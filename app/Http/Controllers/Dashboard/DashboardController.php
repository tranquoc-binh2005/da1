<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\Product\ProductBestSellerResource;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\Http\Repositories\Interfaces\DashboardBuilderRepositoryInterface as DashboardBuilderRepository;
use App\ViewModel\frontend\ProductViewModel;
use App\Enums\StatusOrder;
class DashboardController
{
    use Loggable, HasRender;
    protected DashboardBuilderRepository $dashboardBuilderRepository;
    protected ProductViewModel $productViewModel;

    public function __construct(
        DashboardBuilderRepository $dashboardBuilderRepository,
        ProductViewModel $productViewModel,
    )
    {
        $this->dashboardBuilderRepository = $dashboardBuilderRepository;
        $this->productViewModel = $productViewModel;
    }

    public function index()
    {
        try {
            $this->view('index', [
                'title' => "Dashboard",
                'body' => "layout/dashboard",
                'newCustomers' => !empty($this->getNewCustomerByMonth()['newCustomers']) ? $this->getNewCustomerByMonth()['newCustomers'] : 0,
                'totalPricesByMonth' => !empty($this->getTotalPriceByMonth()['totalPrices']) ? $this->getTotalPriceByMonth()['totalPrices'] : 0,
                'totalPricesByWeek' => !empty($this->getTotalPriceByWeek()['totalPrices']) ? $this->getTotalPriceByWeek()['totalPrices'] : 0,
                'totalPricesByQuarter' => !empty($this->getTotalPriceByQuater()['totalPrices']) ? $this->getTotalPriceByQuater()['totalPrices'] : 0,
                'newOrdersSuccess' => !empty($this->getOrdersSuccessByMonth(StatusOrder::SUCCESS)['newOrders']) ? $this->getOrdersSuccessByMonth(StatusOrder::SUCCESS)['newOrders'] : 0,
                'newOrdersWaiting' => !empty($this->getOrdersSuccessByMonth(StatusOrder::WAITING)['newOrders']) ? $this->getOrdersSuccessByMonth(StatusOrder::WAITING)['newOrders'] : 0,
                'newOrdersProcessing' => !empty($this->getOrdersSuccessByMonth(StatusOrder::PROCESSING)['newOrders']) ? $this->getOrdersSuccessByMonth(StatusOrder::PROCESSING)['newOrders'] : 0,
                'newOrdersFailed' => !empty($this->getOrdersSuccessByMonth(StatusOrder::FAILED)['newOrders']) ? $this->getOrdersSuccessByMonth(StatusOrder::FAILED)['newOrders'] : 0,
                'productBestSellers' => $this->callProductBestSeller()
                ]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    /**
     * @throws \Exception
     */
    private function getNewCustomerByMonth(): int|array
    {
        $month = $this->getMonth();
        return $this->dashboardBuilderRepository->getCustomerByMonth($month);
    }

    /**
     * @throws \Exception
     */
    private function getTotalPriceByMonth(): int|array
    {
        $month = $this->getMonth();
        return $this->dashboardBuilderRepository->getTotalPriceByMonth($month);
    }

    /**
     * @throws \Exception
     */
    private function getTotalPriceByWeek(): int|array
    {
        return $this->dashboardBuilderRepository->getTotalPriceOfCurrentWeek();
    }

    /**
     * @throws \Exception
     */
    private function getTotalPriceByQuater(): array|int
    {
        $month = date('n');
        $currentQuarter = ceil($month / 3);
        return $this->dashboardBuilderRepository->getTotalPriceByQuarter($currentQuarter);
    }

    /**
     * @throws \Exception
     */
    private function getOrdersSuccessByMonth(int $status): int|array
    {
        $month = $this->getMonth();
        return $this->dashboardBuilderRepository->getOrdersByMonth($month, $status);
    }

    private function getMonth(): int|array
    {
        return date('n');
    }

    /**
     * @throws \Exception
     */
    private function callProductBestSeller(): array
    {
        $result = $this->productViewModel->buildProductsBestSeller();
//        print_r($result); die();
        $result = new ProductBestSellerResource($result);
        return $result->toArray();
    }
}