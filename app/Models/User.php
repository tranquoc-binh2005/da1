<?php
namespace App\Models;

class User
{
    protected string $table = 'users';
    protected array $getField = ['tb1.id', 'tb1.email', 'tb1.name', 'tb1.password', 'tb1.address', 'tb1.phone', 'tb1.bio', 'tb1.birthday', 'tb1.image', 'tb1.publish'];
    protected array $getDetail = ['tb1.id', 'tb1.email', 'tb1.name', 'tb1.password', 'tb1.address', 'tb1.phone', 'tb1.bio', 'tb1.birthday', 'tb1.image', 'tb1.publish'];
    protected array $getFieldJoin = [];
    protected array $fillAble = ['user_id', 'email', 'name', 'password', 'address', 'phone', 'bio', 'birthday', 'image', 'created_at', 'updated_at'];

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