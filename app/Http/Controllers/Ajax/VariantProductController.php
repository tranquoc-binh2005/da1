<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Traits\Loggable;
class VariantProductController
{
    use Loggable;
    protected ProductVariantRepository $productVariantRepository;
    public function __construct(ProductVariantRepository $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function getVariantProductById(): void
    {
        header('Content-Type: application/json');
        try {
            $productId = $_POST['productId'];
            $variant = $this->productVariantRepository->findByProductId($productId);
            echo json_encode(['status' => true, 'variant' => $variant]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            $this->handleLogException($e);
        }
    }
}