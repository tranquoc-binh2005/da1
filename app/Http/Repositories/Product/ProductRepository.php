<?php
namespace App\Http\Repositories\Product;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Database;
use App\Models\Product;
use PDO;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected PDO $database;
    protected Product $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Product();
        parent::__construct($this->model);
    }

    public function findByCanonical(string $canonical)
    {
        try {
            $sql = "SELECT tb1.*, tb2.name as name_category, tb3.name as name_brand 
            FROM products as tb1 
            LEFT JOIN product_catalogues as tb2 ON tb1.product_catalogue_id = tb2.id
            LEFT JOIN brand_products as tb3 ON tb1.brand_product_id = tb3.id
            WHERE tb1.canonical = :canonical LIMIT 1";
            return $this->find($sql, [':canonical' => $canonical]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}