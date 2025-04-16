<?php
namespace App\Http\Resources\Cart;

use App\Http\Resources\JsonResource;

class CartItemResource extends JsonResource
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
            'cart_id' => $item['cart_id'] ?? null,
            'product_id' => $item['product_id'] ?? null,
            'product_variant_id' => $item['product_variant_id'] ?? null,
            'quantity' => $item['quantity'] ?? null,
            'unit' => $item['unit'] ?? null,
            'total_price' => $item['total_price'] ?? null,
            'price' => $item['price'] ?? null,
            'sku' => $item['sku'] ?? null,
        ];
    }
}
