<?php
namespace App\Models;

class Voucher
{
    protected string $table = 'vouchers';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as admin_name'];
    protected array $fillAble = ['name', 'value', 'quantity', 'description', 'publish', 'admin_id', 'min', 'max', 'start_at', 'dead_at'];

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