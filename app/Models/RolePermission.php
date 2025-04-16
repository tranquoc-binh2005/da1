<?php
namespace App\Models;

class RolePermission
{
    protected string $table = 'role_permission';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.value'];
    protected array $fillAble = ['role_id', 'permission_id'];

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