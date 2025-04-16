<?php
namespace App\Http\Controllers\Frontend\Checkout;

use App\Http\Controllers\Frontend\BaseController;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\ViewModel\frontend\CartItemViewModel;
use App\Http\Repositories\Interfaces\VoucherRepositoryInterface as VoucherRepository;
use App\ViewModel\frontend\CheckoutViewModel;
use App\Http\Repositories\Interfaces\AddressShoppingRepositoryInterface as AddressShoppingRepository;
use App\Http\Resources\Profile\DetailAddressShoppingResource;
use App\Http\Resources\Profile\AddressShoppingResource;
use App\Http\Services\Interfaces\Checkout\OrderServiceInterface as CheckoutOrderService;
use App\Http\Services\Impl\Payment\PaymentMethodService;
use App\Http\Services\Impl\Payment\PaypalService;
use App\Enums\env;
use Omnipay\Common\Exception\InvalidRequestException;

class CheckoutController extends BaseController
{
    use HasRender, Loggable;

    protected string $dataHeader;
    protected array $dataCart;
    protected CartItemViewModel $cartItemViewModel;
    protected VoucherRepository $voucherRepository;
    protected CheckoutViewModel $checkoutViewModel;
    protected AddressShoppingRepository $addressShoppingRepository;
    protected CheckoutOrderService $orderService;
    protected PaypalService $paypalService;
    protected PaymentMethodService $paymentMethodService;

    public function __construct(
        CartItemViewModel         $cartItemViewModel,
        VoucherRepository         $voucherRepository,
        CheckoutViewModel         $checkoutViewModel,
        AddressShoppingRepository $addressShoppingRepository,
        CheckoutOrderService      $orderService,
        PaymentMethodService      $paymentMethodService,
        PaypalService      $paypalService,
    )
    {
        parent::__construct();
        $this->cartItemViewModel = $cartItemViewModel;
        $this->voucherRepository = $voucherRepository;
        $this->checkoutViewModel = $checkoutViewModel;
        $this->addressShoppingRepository = $addressShoppingRepository;
        $this->orderService = $orderService;
        $this->paymentMethodService = $paymentMethodService;
        $this->paypalService = $paypalService;
    }

    public function checkout(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "checkout/index",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'dataVoucher' => $this->checkIsVoucher(),
                'dataAddressShoppingDefault' => $this->callAddressDefault(),
                'dataAddressShoppingOption' => $this->callAddressShoppingOption()
            ]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    private function checkIsVoucher(): array
    {
        $total = $this->cartItemViewModel->totalCart($this->dataCart);
        return $this->checkoutViewModel->checkVoucher($total);
    }

    /**
     * @throws \Exception
     */
    private function callAddressDefault(): array
    {
        if(!$addressDefault = $this->addressShoppingRepository->getAddressDefault($_SESSION['user']['id'])) return [];
        $data = new DetailAddressShoppingResource($addressDefault);
        return $data->toArray();
    }

    private function callAddressShoppingOption(): array
    {
        if(!$addressDefaultOption = $this->addressShoppingRepository->getAllAddressShopping($_SESSION['user']['id'])) return [];
        $data = new AddressShoppingResource($addressDefaultOption);
        return $data->toArray();
    }

    public function handleCheckout(): void
    {
        try {
            $addressShoppingId = $_POST['address_shopping_id'] ?? $this->createAddressShoppingIsNotExits($_POST);
            $data = [
                'code' => $this->generateCodeOrder(),
                'address_shopping_id' => $addressShoppingId,
                'description' => $_POST['description'],
                'payment_method' => $_POST['payment_method'],
                'total_price' => (int)$_POST['total_price'],
            ];
            match ($data['payment_method']) {
                'paypal' => $this->handleCheckOutPaypal($data),
                'momo' => $this->handleCheckOutMomo($data),
                'cod' => $this->handleCheckOutCod($data),
                default => 'Phương thức thanh toán không hợp lệ',
            };
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    private function createAddressShoppingIsNotExits(array $data): int
    {
        $payload = [
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'user_id' => $_SESSION['user']['id'],
            'isDefault' => 1,
        ];
        return $this->addressShoppingRepository->createAddressShopping($payload);
    }

    private function generateCodeOrder(): string
    {
        return "HATVANG" . rand(100000, 999999);
    }

    private function handleCheckOutCod(array $data): void
    {
        try {
            if(!$this->orderService->save($data)){
                redirect('error', '', 'Có lỗi xảy ra vui lòng thử lại sau', '/gio-hang');
            }
            unset($_SESSION['addressDefault']);
            redirect('success', '', 'Thanh toán đơn hàng thành công', '/don-hang');
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    /**
     * @throws InvalidRequestException
     */
    private function handleCheckOutPaypal(array $data): void
    {
        $total = round(($data['total_price'] / 23000), 2);
        $_SESSION['amount']['paypal'] = $total;
        $_SESSION['order']['paypal'] = $data;
        $returnUrl = env::URL . '/xu-ly-thanh-toan-paypal';
        $cancelUrl = env::URL . '/xu-ly-thanh-toan-paypal-failed';

        $payment = $this->paypalService->createPayment($total, "USD", $returnUrl, $cancelUrl);

        header('Location: ' . $payment->getRedirectUrl());
        exit;
    }

    public function completePaymentPaypal(): void
    {
        try {
            $token = $_GET['token'];
            $PayerID = $_GET['PayerID'];
            if(!$this->paypalService->completePayment($token, $PayerID, $_SESSION['amount']['paypal'], "USD")){
                redirect('error', '', 'Có lỗi xảy ra vui lòng thử lại sau', '/gio-hang');
            }

            if(!$this->orderService->save($_SESSION['order']['paypal'])){
                redirect('error', '', 'Có lỗi xảy ra vui lòng thử lại sau', '/gio-hang');
            }
            unset($_SESSION['amount']['paypal']);
            unset($_SESSION['order']['paypal']);
            unset($_SESSION['addressDefault']);
            redirect('success', '', 'Thanh toán đơn hàng thành công', '/don-hang');
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function completePaymentPaypalFailed(): void
    {
        redirect('error', '', 'Có lỗi xảy ra vui lòng thử lại sau', '/gio-hang');
    }

    private function handleCheckOutMomo(array $data)
    {
        echo "momo"; die();
    }
}