<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\JsonResource;

class ProductCatalogueResource extends JsonResource
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
        ];
    }
}
