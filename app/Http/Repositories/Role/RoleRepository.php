<?php
namespace App\Http\Repositories\Role;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Database;
use App\Models\Role;
use PDO;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected PDO $database;
    protected Role $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Role();
        parent::__construct($this->model);
    }

//    public function all(): array
//    {
//        $sql = "SELECT {$this->model->getField()} FROM {$this->model->getTable()}";
//        $query = $this->setQuery($sql)->getQuery();
//        return ['data' => $this->get($query)];
//    }
}