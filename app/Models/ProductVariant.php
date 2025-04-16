<?php
namespace App\Models;

class ProductVariant
{
    protected string $table = 'product_variants';
    protected array $getField = ['tb1.id', 'tb1.product_id', 'tb1.sku', 'tb1.price', 'tb1.price', 'tb1.publish', 'tb1.unit_id', 'tb1.stock'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = [];
    protected array $fillAble = ['product_id', 'unit_id', 'price', 'stock', 'sku', 'variant_id'];

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