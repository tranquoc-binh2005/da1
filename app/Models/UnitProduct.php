<?php
namespace App\Models;

class UnitProduct
{
    protected string $table = 'unit_products';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = [];
    protected array $fillAble = ['name', 'value', 'unit', 'admin_id'];

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