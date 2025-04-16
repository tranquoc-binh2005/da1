<?php
namespace App\Http\Middleware;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\Role\PermissionRepository;
use App\Http\Repositories\Role\RolePermissionRepository;
use App\Traits\HasAlert;
use App\Traits\HasRender;
class CheckPermission
{
    use HasRender, HasAlert;
    protected PermissionRepository $permissionRepository;
    protected RolePermissionRepository $rolePermissionRepository;
    private $auth;
    public function __construct()
    {
        $this->permissionRepository = new PermissionRepository();
        $this->rolePermissionRepository = new RolePermissionRepository();
        $this->auth = $_SESSION['admin'] ?? null;
    }

    public function handle(): void
    {
        try {
            if(is_null($this->auth)) {
                $this->view('/auth/login')->with('error', "", "Vui lòng đăng nhập để tiếp tục");
                die();
            }
            $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
            $segments = explode('dashboard/', $uri);

            if (!isset($segments[1])) return;
            [$controller, $method] = explode('/', $segments[1]);
            $permissionName = "{$controller}:{$method}";
            $permission = $this->permissionRepository->findByName($permissionName);
            $requireValue = $permission['value'];

            if(!$allPermissionWithRoleId = $this->rolePermissionRepository->getAllPermissionWithRoleId($this->auth['role_id'])){
                $this->helper('401', ['code' => 401, 'title' => 'Không có quyền truy cập', 'message' => 'Không tìm thấy quyền truy cập']);
                die();
            }
            $hasPermission = false;
            $totalPermission = 0;
            foreach ($allPermissionWithRoleId['data'] as $val) {
                $permission = $this->permissionRepository->findByIdAndModule($val['permission_id'], $controller);

                if (empty($permission)) {
                    continue;
                }

                $totalPermission |= $permission['value'];
            }

            if (($totalPermission & $requireValue) === $requireValue) {
                $hasPermission = true;
            }
            if (!$hasPermission) {
                $this->helper('401', ['code' => 401, 'title' => 'Không có quyền truy cập', 'message' => 'Không tìm thấy quyền truy cập']);
                die();
            }
        } catch (ModelNotFoundException $e) {
            $this->helper('401', ['code' => 401, 'title' => 'Không có quyền truy cập', 'message' => $e->getMessage() . $e->getFile() . $e->getLine()]);
            die();
        }
        catch (\Exception $e) {
            echo $e->getMessage() . $e->getFile() . $e->getLine() . $e->getTraceAsString();
            die();
        }
    }
}
