<?php
namespace App\Http\Services\Impl\Order;

use App\Http\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Checkout\OrderServiceInterface;
use App\Http\Repositories\Interfaces\OrderDetailRepositoryInterface as OrderDetailRepository;
use App\Http\Services\Interfaces\Cart\ClientCartServiceInterface as ClientCartService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Classes\Nested;
use App\Traits\HasHook;
use App\Traits\Str;
use App\Models\ProductVariant;
use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Http\Services\Interfaces\Mail\SendMailInvoiceServiceInterface as SendMailInvoiceService;
use App\ViewModel\frontend\HistoryViewModel;

class OrderService extends BaseService implements OrderServiceInterface
{
    use HasHook, Str;
    protected OrderRepository $orderRepository;
    protected ProductVariantRepository $productVariantRepository;
    protected OrderDetailRepository $orderDetailRepository;
    protected ClientCartService $clientCartService;
    protected SendMailInvoiceService $sendMailInvoiceService;
    protected HistoryViewModel $historyViewModel;
    protected $baseRepository;
    protected Order $orderModel;
    protected OrderDetail $orderDetail;
    protected ProductVariant $productVariantModel;
    protected Nested $nested;
    protected string $cacheKeyPrefix;
    protected array $fieldSearch = ['tb1.code', 'tb1.description'];
    protected array $simpleFilter = ['status_order_id'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['status_orders', 'address_shoppings'];

    protected const CACHE_KEY_PREFIX = 'orders';

    public function __construct(
        OrderRepository $orderRepository,
        OrderDetailRepository $orderDetailRepository,
        ClientCartService $clientCartService,
        ProductVariantRepository $productVariantRepository,
        SendMailInvoiceService $sendMailInvoiceService,
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->clientCartService = $clientCartService;
        $this->productVariantRepository = $productVariantRepository;
        $this->sendMailInvoiceService = $sendMailInvoiceService;
        $this->historyViewModel = new HistoryViewModel();
        $this->orderModel = new Order();
        $this->orderDetail = new OrderDetail();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($orderRepository, $this->orderModel);
    }

    public function specification($request): array
    {
        return [
            'type' => $request['type'] ?? '',
            'perpage' => $request['perpage'] ?? self::PER_PAGE,
            'sort' => !empty($request['sort']) ? explode(',', $request['sort']) : ['id', 'desc'],
            'keyword' => [
                'q' => $request['keyword'] ?? '',
                'field' => $this->fieldSearch
            ],
            'filters' => [
                'simple' => $this->buildFilter($request, $this->simpleFilter),
                'complex' => $this->buildFilter($request, $this->complexFilter),
                'date' => $this->buildFilter($request, $this->dateFilter),
            ],
            'with' => $this->with
        ];
    }

    public function prepareModelData(array $payload = []): self
    {
        $payload['user_id'] = $_SESSION['user']['id'];
        $this->initializeBasicData($payload);
        return $this;
    }

    private function initializeBasicData(array $payload = []): void
    {
        $this->payload = $payload;
    }

    public function save(array $payload = [], int $id = null): mixed
    {
        try {
            return $this
                ->beginTransaction()
                ->prepareModelData($payload)
                ->beforeSave()
                ->saveModel($id)
                ->beginTransactionRelation()
                ->beforeRelationModel()
                ->saveRelationModel()
                ->commitRelation()
                ->afterRelationModel()
                ->commit()
                ->sendInvoice()
                ->afterSave($id)
                ->getResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function beforeRelationModel(): self
    {
        $carts = $this->clientCartService->callCart();
        foreach ($carts as $cart) {
            $this->payloadRelation[] = [
                'product_id' => (int)$cart['product_id'],
                'product_variant_id' => (int)$cart['product_variant_id'],
                'quantity' => (int)$cart['quantity'],
                'price' => (int)$cart['price'],
                'order_id' => (int)$this->result
            ];
        }
        return $this;
    }

    /**
     * @throws \Exception
     */
    private function saveRelationModel(): self
    {
        $this->orderDetailRepository->createDetailOrder($this->result, $this->payloadRelation);
        return $this;
    }

    /**
     * @throws \Exception
     */
    private function afterRelationModel(): self
    {
        foreach ($this->payloadRelation as $data) {
            $this->productVariantRepository->updateQuantiyAndSold($data);
        }
        $this->clientCartService->clearCart();
        return $this;
    }

    private function beginTransactionRelation(): self
    {
        $this->orderDetailRepository->getBeginTransaction();
        return $this;
    }

    private function commitRelation(): self
    {
        $this->orderDetailRepository->getCommit();
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function sendInvoice(): self
    {
        foreach ($this->payloadRelation as &$data) {
            $dataInvoice = $this->historyViewModel->getOrderDetailByOrderId($data['order_id']);
        }
        ob_start();
        include __DIR__ . '/../Mail/template/invoice.php';
        $templateInvoice = ob_get_clean();
        $this->sendMailInvoiceService->sendInvoiceToClient(
            $_SESSION['user']['email'],
            "No Reply | Hoá đơn điện tử | Hạt Vàng Organic",
            $templateInvoice
        );

        return $this;
    }

}