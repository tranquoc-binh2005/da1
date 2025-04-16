<?php
namespace App\Http\Repositories\Role;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Models\Database;
use App\Models\Permission;
use PDO;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected PDO $database;
    protected Permission $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new Permission();
        parent::__construct($this->model);
    }

    public function findByIdAndModule(int $id = null,string $module = '' ): string|array
    {
        try {
            $sql = "SELECT * FROM {$this->model->getTable()} AS tb1 WHERE tb1.id = :id AND tb1.module = :module AND tb1.publish = 1";
            if (!$result = $this->find($sql, ['id' => $id, 'module' => $module])) {
                return '';
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findByName(string $name): array|string
    {
        try {
            $sql = "SELECT " . implode(', ', $this->model->getField()) . " FROM {$this->model->getTable()} AS tb1 WHERE tb1.name = :value AND tb1.publish = 1";
            if (!$result = $this->find($sql, ['value' => $name])) {
                throw new ModelNotFoundException("Không tìm thấy quyền");
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}