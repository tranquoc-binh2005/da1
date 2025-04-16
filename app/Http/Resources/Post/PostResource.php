<?php
namespace App\Http\Resources\Post;

use App\Http\Resources\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(): array
    {
        if (is_array($this->resource)) {
            return array_map(function($item) {
                return $this->transformItem($item);
            }, $this->resource);
        }

        return $this->transformItem($this->resource);
    }

    private function transformItem($item): array
    {
        return [
            'id' => $item['id'] ?? null,
            'name' => $item['name'] ?? null,
            'canonical' => $item['canonical'] ?? null,
            'description' => $item['description'] ?? null,
            'image' => $item['image'] ?? null,
            'postCatalogueName' => $item['postCatalogueName'] ?? null,
            'created_at' => $item['created_at'] ?? null,
        ];
    }
}
