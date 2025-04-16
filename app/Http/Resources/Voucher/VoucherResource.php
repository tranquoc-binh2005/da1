<?php
namespace App\Http\Resources\Voucher;

use App\Http\Resources\JsonResource;

class VoucherResource extends JsonResource
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
            'value' => $item['value'] ?? null,
            'min' => $item['min'] ?? null,
            'max' => $item['max'] ?? null,
            'quantity' => $item['quantity'] ?? null,
            'start_at' => $item['start_at'] ?? null,
            'dead_at' => $item['dead_at'] ?? null,
        ];
    }
}