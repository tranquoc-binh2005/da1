<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\JsonResource;

class ProductRatingResource extends JsonResource
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
            'customer_name' => $item['customer_name'] ?? null,
            'customer_email' => $item['customer_email'] ?? null,
            'customer_content' => $item['customer_content'] ?? null,
            'rating' => $item['rating'] ?? null,
            'rating_text' => $item['rating_text'] ?? null,
            'created_at' => $item['created_at'] ?? null,
        ];
    }
}
