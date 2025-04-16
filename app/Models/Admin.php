<?php
namespace App\Models;

class Admin
{
    protected string $table = 'admins';
    protected array $getField = ['tb1.*'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as role_name', 'tb2.canonical as role_canonical', 'tb3.name as admin_name'];
    protected array $fillAble = ['admin_id', 'role_id', 'name', 'password', 'address', 'phone', 'bio', 'publish', 'birthday', 'image', 'email'];

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