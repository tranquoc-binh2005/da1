<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\JsonResource;

class ProductVariantResource extends JsonResource
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
            'price' => $item['price'] ?? null,
            'stock' => $item['stock'] ?? null,
            'sku' => $item['sku'] ?? null,
            'unit_value' => $item['unit_value'] ?? null,
            'unit_name' => $item['unit_name'] ?? null,
        ];
    }
}
