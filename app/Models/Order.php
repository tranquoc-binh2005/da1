<?php
namespace App\Models;

class Order
{
    protected string $table = 'orders';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as status_order_name', 'tb3.name as address_shopping_name', 'tb3.address as address_shopping_address', 'tb3.phone as address_shopping_phone'];
    protected array $fillAble = ['code', 'user_id', 'status_order_id', 'total_price', 'payment_method', 'description', 'address_shopping_id'];

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