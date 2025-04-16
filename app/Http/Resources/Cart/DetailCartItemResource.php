<?php
namespace App\Http\Resources\Cart;

use App\Http\Resources\JsonResource;

class DetailCartItemResource extends JsonResource
{
    public function toArray(): array
    {
        return $this->transformItem($this->resource);
    }

    private function transformItem($item): array
    {
        return [
            'name' => $item['name'] ?? null,
            'description' => $item['description'] ?? null,
            'image' => $item['image'] ?? null,
        ];
    }
}