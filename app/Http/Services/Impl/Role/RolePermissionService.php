<?php
namespace App\Http\Services\Impl\Role;

use App\Http\Repositories\Interfaces\RolePermissionRepositoryInterface as RolePermissionRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Role\PermissionServiceInterface;
use App\Models\Permission;

class RolePermissionService extends BaseService implements PermissionServiceInterface
{
    protected RolePermissionRepository $rolePermissionRepository;
    protected Permission $permissionModel;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['permissions'];

    protected const CACHE_KEY_PREFIX = 'permissions';

    public function __construct(
        RolePermissionRepository $rolePermissionRepository,
    )
    {
        $this->rolePermissionRepository = $rolePermissionRepository;
        $this->permissionModel = new Permission();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($rolePermissionRepository, $this->permissionModel);
    }

    public function prepareModelData(array $payload = []): self
    {
        $this->initializeBasicData($payload);
        return $this;
    }

    private function initializeBasicData(array $payload = []): void
    {
        $payload['admin_id'] = $_SESSION['admin']['id'];
        if (isset($payload['password']) && !password_get_info($payload['password'])['algo']) {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        }
        $this->payload = $payload;
    }
}