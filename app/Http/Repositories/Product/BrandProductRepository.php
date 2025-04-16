<?php
namespace App\Http\Repositories\Product;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\BrandProductRepositoryInterface;
use App\Models\Database;
use App\Models\BrandProduct;
use PDO;

class BrandProductRepository extends BaseRepository implements BrandProductRepositoryInterface
{
    protected PDO $database;
    protected BrandProduct $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new BrandProduct();
        parent::__construct($this->model);
    }
}