<?php
namespace App\Models;

class Product
{
    protected string $table = 'products';
    protected array $getField = ['tb1.name', 'tb1.canonical', 'tb1.description', 'tb1.image', 'tb1.post_catalogue_id', 'tb1.publish', 'tb1.id', 'tb1.price_default'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = [
        'tb2.name as admin_name',
        'tb3.name as category_name',
        'tb4.name as brand_name'
    ];
    protected array $fillAble = [
        'name', 'canonical', 'product_catalogue_id',
        'brand_product_id', 'description', 'meta_title',
        'meta_keyword', 'meta_description', 'image',
        'publish', 'order', 'content', 'admin_id', 'album',
        'discount', 'start_date', 'end_date'
    ];

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