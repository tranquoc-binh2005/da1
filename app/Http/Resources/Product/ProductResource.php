<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\JsonResource;

class ProductResource extends JsonResource
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
            'discount' => $item['discount'] ?? null,
            'start_date' => $item['start_date'] ?? null,
            'end_date' => $item['end_date'] ?? null,
            'total_sold' => $item['total_sold'] ?? null,
        ];
    }
}
