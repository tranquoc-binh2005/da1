<?php
namespace App\Http\Controllers\Frontend\Contact;
use App\Http\Controllers\Frontend\BaseController;
use App\ViewModel\frontend\ProfileViewModel;
use App\Http\Resources\Profile\AddressShoppingResource;
class ContactController extends BaseController
{
    protected ProfileViewModel $profileViewModel;
    public function __construct()
    {
        parent::__construct();
        $this->profileViewModel = new ProfileViewModel();
    }

    public function contact(): void
    {
        try {
            $this->render('frontend/index', [
                'title' => "Thông tin cá nhân",
                'body' => "contact/index",
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