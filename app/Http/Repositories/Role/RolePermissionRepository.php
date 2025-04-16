<?php
namespace App\Http\Repositories\Role;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\RolePermissionRepositoryInterface;
use App\Models\Database;
use PDO;
use App\Models\RolePermission;
use PDOException;

class RolePermissionRepository extends BaseRepository implements RolePermissionRepositoryInterface
{
    protected PDO $database;
    protected RolePermission $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new RolePermission();
        parent::__construct($this->model);
    }

    public function getAllPermissionWithRoleId(int $role_id = null): array
    {
        $sql = "SELECT permission_id, role_id FROM {$this->model->getTable()} WHERE role_id = $role_id";
//        echo $sql; die();
        $query = $this->setQuery($sql)->getQuery();
        return ['data' => $this->get($query)];
    }

    public function sync(array $payload = []): bool
    {
        try {
            [$role_id] = array_keys($payload);
            $permission_ids = $payload[$role_id];

            $sqlDelete = "DELETE FROM {$this->model->getTable()} WHERE role_id = :role_id";
            $this->execute($sqlDelete, ["role_id" => $role_id]);

            $sqlInsert = "INSERT INTO {$this->model->getTable()} (role_id, permission_id) VALUES (:role_id, :permission_id)";

            foreach ($permission_ids as $permission_id) {
                $this->execute($sqlInsert, ["role_id" => $role_id, "permission_id" => $permission_id]);
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}