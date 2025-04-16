<?php

namespace App\ViewModel\frontend;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductVariantResource;
use App\Http\Repositories\Product\ProductVariantRepository;
use App\Models\Database;
use App\Traits\Str;

class ProductViewModel
{
    use Str;

    protected ProductVariantRepository $productVariantRepository;
    protected Database $database;

    public function __construct()
    {
        $this->database = new Database();
        $this->productVariantRepository = new ProductVariantRepository($this->database);
    }

    protected function checkDiscount($product): int
    {
        $currentDate = date('Y-m-d');
        if ($currentDate >= $product['start_date'] && $currentDate <= $product['end_date']) {
            return (int)$product['discount'];
        }
        return 0;
    }

    protected function applyDiscount($price, $discount): int
    {
        if (is_numeric($discount) && $discount > 0 && $discount <= 100) {
            return floor($price * (100 - $discount) / 100);
        }
        return 0;
    }

    /**
     * @throws \Exception
     */
    public function getVariantsProduct(array $products): array
    {
        $isSingle = isset($products['id']);

        if ($isSingle) {
            $products = [$products];
        }

        foreach ($products as &$product) {
            if (!isset($product['id'])) continue;

            $variants = new ProductVariantResource(
                $this->productVariantRepository->findByProductId((int)$product['id'])
            );
            $product['variants'] = $variants->toArray();

            // Kiểm tra thời gian giảm giá hợp lệ trước khi dùng
            $product['discount'] = $this->checkDiscount($product);

            if (!empty($product['variants'])) {
                usort($product['variants'], function ($a, $b) {
                    return $a['price'] <=> $b['price'];
                });

                foreach ($product['variants'] as $variant) {
                    if ($variant['stock'] > 0) {
                        $product['default_variant'] = $variant;
                        break;
                    }
                }

                if (!isset($product['default_variant'])) {
                    $product['default_variant'] = $product['variants'][0];
                }

                foreach ($product['variants'] as &$variant) {
                    $variant['price_sale'] = $this->applyDiscount($variant['price'], $product['discount']);
                    $variant['unit'] = $variant['unit_value'] . $variant['unit_name'];
                }
            }

            $product['default_variant']['price_sale'] = $this->applyDiscount(
                $product['default_variant']['price'] ?? 0,
                $product['discount']
            );
        }

        return $isSingle ? $products[0] : $products;
    }

    /**
     * @throws \Exception
     */
    public function buildNavigation(array $paginationProducts): array
    {
        $paginationProductsResource = new ProductResource($paginationProducts['data']);
        $paginationProducts['data'] = $paginationProductsResource->toArray();
        return $paginationProducts;
    }

    /**
     * @throws \Exception
     */
    public function buildVariantsProduct(array $dataProducts): array
    {
        return $this->getVariantsProduct($dataProducts);
    }

    /**
     * @throws \Exception
     */
    public function buildProductsBestSeller(): array
    {
        $products = $this->productVariantRepository->productBestSelling();
        return $this->buildVariantsProduct($products);
    }
}
