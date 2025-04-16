<?php
namespace App\Http\Resources\Post;

use App\Http\Resources\JsonResource;

class DetailPostResource extends JsonResource
{
    public function toArray(): array
    {
        return $this->transformItem($this->resource);
    }

    private function transformItem($item): array
    {
        return [
            'id' => $item['id'] ?? null,
            'name' => $item['name'] ?? null,
            'canonical' => $item['canonical'] ?? null,
            'description' => $item['description'] ?? null,
            'content' => $item['content'] ?? null,
            'image' => $item['image'] ?? null,
            'meta_title' => $item['meta_title'] ?? null,
            'meta_keyword' => $item['meta_keyword'] ?? null,
            'meta_description' => $item['meta_description'] ?? null,
            'created_at' => $item['created_at'] ?? null,
            'name_catalogues' => $item['name_catalogues'] ?? null,
            'post_catalogue_id' => $item['post_catalogue_id'] ?? null,
            'author' => $item['author'] ?? null,
        ];
    }
}