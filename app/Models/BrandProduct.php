<?php
namespace App\Models;

class BrandProduct
{
    protected string $table = 'brand_products';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as admin_name'];
    protected array $fillAble = ['name', 'description', 'image', 'admin_id'];

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