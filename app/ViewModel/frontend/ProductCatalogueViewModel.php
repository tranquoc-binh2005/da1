<?php
namespace App\ViewModel\frontend;

use App\Http\Repositories\Product\ProductCatalogueRepository;
use App\Models\Database;
class ProductCatalogueViewModel
{
    protected ProductCatalogueRepository $productCatalogueRepository;
    protected Database $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->productCatalogueRepository = new ProductCatalogueRepository($this->database);
    }

    /**
     * @throws \Exception
     */
    public function buildCountProducts(array $categories): array
    {
        foreach ($categories as &$category) {
            $category['countProducts'] = $this->countProductsByCategories($category['id'])['total_products'];
        }
        return $categories;
    }

    /**
     * @throws \Exception
     */
    private function countProductsByCategories(int $productCatalogueId): array
    {
        return $this->productCatalogueRepository->getCountProductByCategoryId($productCatalogueId);
    }
}