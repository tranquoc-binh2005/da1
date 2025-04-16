<?php
namespace App\Http\Controllers\Dashboard\Role;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Request\Role\CreateRequest;
use App\Http\Request\Role\UpdateRequest;
use App\Http\Services\Interfaces\Role\RoleServiceInterface as RoleService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class RoleController extends BaseController
{
    use Loggable, HasRender;
    protected RoleService $roleService;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        RoleService $roleService,
    )
    {
        $this->roleService = $roleService;
        parent::__construct($roleService);
    }

    public function index()
    {
        try {
            $roles = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý nhóm quản trị", 'body' => "role/index", 'roles' => $roles]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $this->view('index', ['title' => "Tạo nhóm quản trị", 'body' => "role/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $role = $this->baseShow($id);
            $this->view('index', ['title' => "Cập nhật nhóm quản trị", 'body' => "role/store", 'role' => $role]);
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
                    'name' => $this->storeRequest->input('name'),
                    'canonical' => $this->storeRequest->input('canonical'),
                ]);
                $this->view('index', ['body' => "role/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "role/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput(['name', 'canonical']);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/role/index');
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
                    'canonical' => $this->updateRequest->input('canonical'),
                ]);
                $role = $this->baseShow($id);
                $this->view('index', [
                    'body' => "role/store",
                    'errors' => $this->updateRequest->errors(),
                    'role' => $role,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "role/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput(['name', 'canonical']);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/roles/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $role = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá nhóm quản trị", 'body' => "role/delete", 'role' => $role]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $role = $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/roles/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}