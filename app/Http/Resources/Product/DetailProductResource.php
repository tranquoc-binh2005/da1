<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\JsonResource;

class DetailProductResource extends JsonResource
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
            'name_category' => $item['name_category'] ?? null,
            'name_brand' => $item['name_brand'] ?? null,
            'image' => $item['image'] ?? null,
            'album' => $item['album'] ?? null,
            'discount' => $item['discount'] ?? null,
            'meta_title' => $item['meta_title'] ?? null,
            'meta_keyword' => $item['meta_keyword'] ?? null,
            'meta_description' => $item['meta_description'] ?? null,
            'variants' => $item['variants'] ?? null,
            'default_variant' => $item['default_variant'] ?? null,
        ];
    }
}