<?php
namespace App\Models;

class AddressShopping
{
    protected string $table = 'address_shoppings';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $fillAble = ['user_id', 'name', 'phone', 'address', 'isDefault'];
    protected array $getFieldJoin = [];

    public function getTable(): string
    {
        return $this->table;
    }

    public function getField(): array
    {
        return $this->getField;
    }

    public function fillAble(): array
    {
        return $this->fillAble;
    }

    public function getFieldJoin(): array
    {
        return $this->getFieldJoin;
    }

    public function getDetail(): array
    {
        return $this->getDetail;
    }
}