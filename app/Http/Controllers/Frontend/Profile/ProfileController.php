<?php
namespace App\Http\Controllers\Frontend\Profile;
use App\Http\Controllers\Frontend\BaseController;
use App\ViewModel\frontend\ProfileViewModel;
use App\Http\Resources\Profile\AddressShoppingResource;
class ProfileController extends BaseController
{
    protected ProfileViewModel $profileViewModel;
    public function __construct()
    {
        parent::__construct();
        $this->profileViewModel = new ProfileViewModel();
    }

    public function profile(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Thông tin cá nhân",
                'body' => "profile/index",
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

    public function password(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Cập nhật mật khẩu",
                'body' => "profile/password",
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

    public function address(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Cập nhật địa chỉ",
                'body' => "profile/address",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'dataAddressShopping' => $this->buildDataAddressShopping($this->profileViewModel->callAddressShopping($_SESSION['user']['id'])),
            ]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    private function buildDataAddressShopping(array $data): array
    {
        $data = new AddressShoppingResource($data);
        return $data->toArray();
    }
}