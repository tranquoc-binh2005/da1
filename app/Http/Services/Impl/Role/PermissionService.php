<?php
namespace App\Http\Services\Impl\Role;

use App\Http\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Role\PermissionServiceInterface;
use App\Models\Permission;
use App\Http\Repositories\Role\RolePermissionRepository;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    protected PermissionRepository $permissionRepository;
    protected RolePermissionRepository $rolePermissionRepository;
    protected Permission $permissionModel;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = [];

    protected const CACHE_KEY_PREFIX = 'permissions';

    public function __construct(
        PermissionRepository $permissionRepository
    )
    {
        $this->permissionRepository = $permissionRepository;
        $this->rolePermissionRepository = new RolePermissionRepository();
        $this->permissionModel = new Permission();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($permissionRepository, $this->permissionModel);
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

    public function syncPermissions(array $payload = []): bool
    {
        try {
            return $this->rolePermissionRepository->sync($payload['permission']);
        } catch (\Exception $e) {
            throw $e;
        }

    }
}