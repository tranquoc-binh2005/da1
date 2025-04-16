<?php
namespace App\Models;

class CartItem
{
    protected string $table = 'cart_items';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = [];
    protected array $fillAble = ['product_id', 'product_variant_id', 'cart_id', 'quantity', 'unit', 'total_price', 'price'];

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