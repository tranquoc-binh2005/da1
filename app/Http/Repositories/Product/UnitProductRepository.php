<?php
namespace App\Http\Repositories\Product;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\UnitProductRepositoryInterface;
use App\Models\Database;
use App\Models\UnitProduct;
use PDO;

class UnitProductRepository extends BaseRepository implements UnitProductRepositoryInterface
{
    protected PDO $database;
    protected UnitProduct $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new UnitProduct();
        parent::__construct($this->model);
    }

    public function test(){
        echo 12483273; die();
    }
}