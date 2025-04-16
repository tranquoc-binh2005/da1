<?php
namespace App\Http\Controllers\Dashboard\Role;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Role\RolePermissionRepository;
use App\Http\Request\Permission\CreateRequest;
use App\Http\Request\Permission\SaveRequest;
use App\Http\Request\Permission\UpdateRequest;
use App\Http\Services\Interfaces\Role\PermissionServiceInterface as PermissionService;
use App\Http\Services\Interfaces\Role\RoleServiceInterface as RoleService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class PermissionController extends BaseController
{
    use Loggable, HasRender;
    protected PermissionService $permissionService;
    protected RoleService $roleService;
    protected RolePermissionRepository $rolePermissionRepository;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    protected SaveRequest $saveRequest;
    public function __construct(
        PermissionService $permissionService,
        RoleService $roleService,
        RolePermissionRepository $rolePermissionRepository,
    )
    {
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
        $this->rolePermissionRepository = $rolePermissionRepository;
        parent::__construct($permissionService);
    }

    public function index()
    {
        try {
            $permissions = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý quyền", 'body' => "permission/index", 'permissions' => $permissions]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $this->view('index', ['title' => "Tạo quyền quản trị", 'body' => "permission/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $permission = $this->baseShow($id);
            $this->view('index', ['title' => "Cập nhật quyền quản trị", 'body' => "permission/store", 'permission' => $permission]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function store(): void
    {
        try {
            $this->storeRequest = new CreateRequest();
            if ($this->storeRequest->fails()) {
                withInput([
                    'name' => $this->storeRequest->input('name') ?? '',
                    'module' => $this->storeRequest->input('module') ?? '',
                    'title' => $this->storeRequest->input('title') ?? '',
                    'description' => $this->storeRequest->input('description') ?? '',
                    'value' => $this->storeRequest->input('value') ?? '',
                ]);
                $this->view('index', ['body' => "permission/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "permission/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput(['name', 'module' , 'title', 'description', 'value']);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/permissions/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function update(int $id): void
    {
        try {
            $this->updateRequest = new UpdateRequest($id);
            if ($this->updateRequest->fails()) {
                withInput([
                    'name' => $this->updateRequest->input('name'),
                    'module' => $this->updateRequest->input('module'),
                    'title' => $this->updateRequest->input('title'),
                    'description' => $this->updateRequest->input('description'),
                    'value' => $this->updateRequest->input('value'),
                ]);
                $permission = $this->baseShow($id);
                $this->view('index', [
                    'body' => "permission/store",
                    'errors' => $this->updateRequest->errors(),
                    'permission' => $permission,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "permission/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput(['name', 'module' , 'title', 'description', 'value']);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/permissions/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $permission = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá quyền quản trị", 'body' => "permission/delete", 'permission' => $permission]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/permissions/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function bulkStore(): void
    {
        try {
            $roles = $this->roleService->paginate($_GET);
            $this->view('index', ['body' => "permission/setPermission/table", 'title' => "Phân quyền", 'roles' => $roles]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function setPermission(int $id = null): void
    {
        try {
            $role = $this->roleService->show($id);
            $permissions = $this->groupPermissionsByModule($this->baseIndex('all')['data']);
            $isPermissionSelected = $this->rolePermissionRepository->getAllPermissionWithRoleId($role['id']);
            $this->view('index', ['body' => "permission/setPermission/set", 'title' => "Phân quyền", 'role' => $role, 'permissions' => $permissions, 'isPermissionSelected' => $isPermissionSelected]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    private function groupPermissionsByModule(array $permissions): array {
        $grouped = [];

        foreach ($permissions as $permission) {
            if (is_array($permission) && array_key_exists(0, $permission)) {
                foreach ($permission as $item) {
                    $grouped[$item['module']][] = $item;
                }
            } else {
                $grouped[$permission['module']][] = $permission;
            }
        }

        return $grouped;
    }

    public function savePermission(): void
    {
        try {
            $this->saveRequest = new SaveRequest();
            $role_id = $this->saveRequest->input('role_id');
            $role = $this->roleService->show($role_id);
            $permissions = $this->groupPermissionsByModule($this->baseIndex('all')['data']);
            $isPermissionSelected = $this->rolePermissionRepository->getAllPermissionWithRoleId($role['id']);
            if ($this->saveRequest->fails()) {
                $this->view('index', [
                    'body' => "permission/setPermission/set",
                    'role' => $role,
                    'title' => "Phân quyền",
                    'permissions' => $permissions,
                    'isPermissionSelected' => $isPermissionSelected,
                    'errors' => $this->saveRequest->errors()]
                );
                die();
            }

            if(!$payload = $this->saveRequest->validated()){
                $this->view('index', [
                        'body' => "permission/setPermission/set",
                        'role' => $role,
                        'title' => "Phân quyền",
                        'permissions' => $permissions,
                        'isPermissionSelected' => $isPermissionSelected,
                        'errors' => $this->saveRequest->errors()]
                );
                die();
            }
            $this->permissionService->syncPermissions($payload);
            redirect('success', '', 'Cập nhật quyền thành công', '/dashboard/permissions/bulkStore');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}