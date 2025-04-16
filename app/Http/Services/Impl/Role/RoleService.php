<?php
namespace App\Http\Services\Impl\Role;

use App\Http\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Role\RoleServiceInterface;
use App\Models\Role;

class RoleService extends BaseService implements RoleServiceInterface
{
    protected RoleRepository $roleRepository;
    protected Role $roleModel;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['admins'];

    protected const CACHE_KEY_PREFIX = 'roles';

    public function __construct(
        RoleRepository $roleRepository,
    )
    {
        $this->roleRepository = $roleRepository;
        $this->roleModel = new role();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($roleRepository, $this->roleModel);
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