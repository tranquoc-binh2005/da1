<?php
namespace App\Http\Resources\Profile;

use App\Http\Resources\JsonResource;

class AddressShoppingResource extends JsonResource
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
            'user_id' => $item['user_id'] ?? null,
            'phone' => $item['phone'] ?? null,
            'address' => $item['address'] ?? null,
            'isDefault' => $item['isDefault'] ?? null,
        ];
    }
}
