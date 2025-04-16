<?php
namespace App\Models;

class Post
{
    protected string $table = 'posts';
    protected array $getField = ['tb1.name', 'tb1.canonical', 'tb1.description', 'tb1.image', 'tb1.post_catalogue_id', 'tb1.publish', 'tb1.id'];
    protected array $getDetail = ['tb1.*'];
    protected array $getFieldJoin = ['tb2.name as postCatalogueName'];
    protected array $fillAble = ['name', 'canonical', 'post_catalogue_id', 'description', 'meta_title', 'meta_keyword', 'meta_description', 'image', 'publish', 'order', 'content', 'admin_id'];

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