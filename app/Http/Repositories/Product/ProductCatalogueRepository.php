<?php
namespace App\Http\Repositories\Product;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Models\Database;
use App\Models\ProductCatalogue;
use PDO;

class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
{
    protected PDO $database;
    protected ProductCatalogue $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new ProductCatalogue();
        parent::__construct($this->model);
    }

    public function getCountProductByCategoryId(int $product_catalogue_id): array
    {
        try {
            $sql = "SELECT COUNT(*) AS total_products FROM products WHERE product_catalogue_id = :product_catalogue_id";
            return $this->find($sql, [':product_catalogue_id' => $product_catalogue_id]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}