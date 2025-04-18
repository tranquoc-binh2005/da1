<?php
namespace App\Http\Controllers\Frontend\Setting;
use App\Http\Controllers\Frontend\BaseController;
use App\ViewModel\frontend\ProfileViewModel;
use App\Http\Resources\Profile\AddressShoppingResource;
class SettingController extends BaseController
{
    protected ProfileViewModel $profileViewModel;
    public function __construct()
    {
        parent::__construct();
        $this->profileViewModel = new ProfileViewModel();
    }

    public function setting(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Thông tin cá nhân",
                'body' => "setting/index",
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