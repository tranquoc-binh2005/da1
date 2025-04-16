<?php
namespace App\ViewModel\frontend;

use App\Http\Repositories\AddressShopping\AddressShoppingRepository;
use App\Models\Database;
class ProfileViewModel
{
    protected AddressShoppingRepository $addressShoppingRepository;
    protected Database $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->addressShoppingRepository = new AddressShoppingRepository($this->database);
    }

    /**
     * @throws \Exception
     */
    public function callAddressShopping(int $userId): array
    {
        return $this->addressShoppingRepository->getAllAddressShopping($userId);
    }
}