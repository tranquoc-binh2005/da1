<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\JsonResource;

class ProductBestSellerResource extends JsonResource
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
            'total_sold' => $item['total_sold'] ?? null,
            'canonical' => $item['canonical'] ?? null,
            'image' => $item['image'] ?? null,
            'product_catalogue_name' => $item['product_catalogue_name'] ?? null,
            'product_brand_name' => $item['product_brand_name'] ?? null,
            'default_variant' => $item['default_variant'] ?? null,
        ];
    }
}
