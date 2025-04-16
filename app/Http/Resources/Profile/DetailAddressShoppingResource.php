<?php
namespace App\Http\Resources\Profile;

use App\Http\Resources\JsonResource;

class DetailAddressShoppingResource extends JsonResource
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
            'address' => $item['address'] ?? null,
            'phone' => $item['phone'] ?? null,
            'isDefault' => $item['isDefault'] ?? null,
            'user_id' => $item['user_id'] ?? null,
        ];
    }
}