<?php

namespace App\Http\Resources;

class JsonResource
{
    protected mixed $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function toArray(): array
    {
        if (is_array($this->resource) && isset($this->resource[0])) {
            return array_map(function ($item) {
                return (array) $item;
            }, $this->resource);
        }

        return (array) $this->resource;
    }

    /**
     * Khi gọi trực tiếp object, sẽ trả về mảng thay vì cần gọi toArray()
     */
    public function __invoke(): array
    {
        return $this->toArray();
    }
}
