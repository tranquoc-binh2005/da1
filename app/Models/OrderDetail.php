<?php
namespace App\Models;

class OrderDetail
{
    protected string $table = 'order_details';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = [
        'tb2.name', 'tb2.description', 'tb2.image',
        'tb3.price', 'tb3.sku',
        'tb4.name as unit_name', 'tb4.value as unit_value', 'tb4.unit as unit_unit',
    ];
    protected array $fillAble = ['order_id','product_id', 'product_variant_id', 'quantity', 'price', 'sku'];

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