<?php
namespace App\Http\Resources\History;

use App\Http\Resources\JsonResource;

class HistoryResource extends JsonResource
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
            'code' => $item['code'] ?? null,
            'total_price' => $item['total_price'] ?? null,
            'payment_method' => $item['payment_method'] ?? null,
            'description' => $item['description'] ?? null,
            'status_order_name' => $item['status_order_name'] ?? null,
            'status_order_id' => $item['status_order_id'] ?? null,
            'address_shopping_name' => $item['address_shopping_name'] ?? null,
            'address_shopping_address' => $item['address_shopping_address'] ?? null,
            'address_shopping_phone' => $item['address_shopping_phone'] ?? null,
        ];
    }
}
