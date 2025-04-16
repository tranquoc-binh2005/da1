<?php
namespace App\Models;

class ProductCatalogue
{
    protected string $table = 'product_catalogues';
    protected array $getField = ['tb1.name', 'tb1.canonical', 'tb1.description', 'tb1.level', 'tb1.image', 'tb1.parent_id', 'tb1.publish', 'tb1.id', 'tb1.lft', 'tb1.rgt'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as admin_name'];
    protected array $fillAble = ['name', 'canonical', 'parent_id', 'description', 'meta_title', 'meta_keyword', 'meta_description', 'image', 'publish', 'lft', 'rgt', 'level', 'order'];

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