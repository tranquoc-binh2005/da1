<?php
namespace App\Models;

class Role
{
    protected string $table = 'roles';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as admin'];
    protected array $fillAble = ['name', 'canonical', 'publish', 'admin_id'];

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