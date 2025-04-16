<?php

namespace App\Http\Repositories\Interfaces;
interface AddressShoppingRepositoryInterface
{
    public function createAddressShopping(array $data): int;
    public function getAllAddressShopping(int $userId): array;
    public function detailAddressShopping(array $payload): array;
    public function deleteAddressShopping(int $id): int;
    public function updateAddressShopping(array $data): bool;
}