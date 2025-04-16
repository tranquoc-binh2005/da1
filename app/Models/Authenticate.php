<?php
namespace App\Models;

class Authenticate
{
    protected string $table = '';
    protected array $getField = ['name'];
    protected array $getDetail = ['tb1.*'];
    protected array $fillAble = ['name', 'email', 'password'];
    protected array $getFieldJoin = [];
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