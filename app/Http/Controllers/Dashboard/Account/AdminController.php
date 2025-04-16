<?php
namespace App\Http\Controllers\Dashboard\Account;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Role\RoleRepository as RoleRepository;
use App\Http\Request\Admin\CreateRequest;
use App\Http\Request\Admin\UpdateRequest;
use App\Http\Services\Interfaces\Account\AdminServiceInterface as AdminService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class AdminController extends BaseController
{
    use Loggable, HasRender;
    protected AdminService $adminService;
    protected RoleRepository $roleRepository;
    protected CreateRequest $createRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        AdminService $adminService,
        RoleRepository $roleRepository,
    )
    {
        $this->adminService = $adminService;
        $this->roleRepository = $roleRepository;
        parent::__construct($adminService);
    }

    public function index(): void
    {
        try {
            $admins = $this->baseIndex();
            $roles = $this->roleRepository->all()['data'];
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'publish' => $_GET['publish'] ?? 1,
                'sort' => $_GET['sort'] ?? 1,
                'role_id' => $_GET['role_id'] ?? null,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý người dùng", 'body' => "admin/index", 'admins' => $admins, 'roles' => $roles]);
        } catch (\Exception $e){
            $this->handleLogException($e, $message = "loi"); die();
        }
    }

    public function create(): void
    {
        $roles = $this->roleRepository->all()['data'];
        $this->view('index', ['title' => "Tạo người dùng", 'body' => "admin/store", 'roles' => $roles]);
    }

    public function show(int $id = null): void
    {
        try {
            $roles = $this->roleRepository->all()['data'];
            $admin = $this->baseShow($id);
            $this->view('index', ['title' => "Cập nhật người dùng", 'body' => "admin/store", 'admin' => $admin, 'roles' => $roles]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function store(): void
    {
        try {
            $this->createRequest = new CreateRequest();
            if ($this->createRequest->fails()) {
                $roles = $this->roleRepository->all()['data'];
                withInput([
                    'email' => $this->createRequest->input('email'),
                    'name' => $this->createRequest->input('name'),
                    'phone' => $this->createRequest->input('phone'),
                    'bio' => $this->createRequest->input('bio'),
                    'address' => $this->createRequest->input('address'),
                    'birthday' => $this->createRequest->input('birthday'),
                    'image' => $this->createRequest->input('image'),
                    'role_id' => $this->createRequest->input('role_id'),
                ]);

                $this->view('index', ['body' => "admin/store", 'roles' => $roles, 'errors' => $this->createRequest->errors()]);
                die();
            }
            if(!$payload = $this->createRequest->validated()){
                echo 99;
                $this->view('index', ['body' => "admin/store",'errors' => $this->createRequest->errors()]);
                die();
            }
            $payload['image'] = $this->createRequest->file('image');
            $this->baseSave($payload);
            clearOldInput(['email', 'name', 'phone', 'bio', 'address', 'birthday', 'image', 'role_id']);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/admins/index');
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
                    'email' => $this->updateRequest->input('email'),
                    'name' => $this->updateRequest->input('name'),
                    'phone' => $this->updateRequest->input('phone'),
                    'bio' => $this->updateRequest->input('bio'),
                    'address' => $this->updateRequest->input('address'),
                    'birthday' => $this->updateRequest->input('birthday'),
                    'image' => $this->updateRequest->input('image'),
                    'role_id' => $this->updateRequest->input('role_id')
                ]);
                $roles = $this->roleRepository->all()['data'];
                $admin = $this->baseShow($id);
                $this->view('index', [
                    'body' => "admin/store",
                    'errors' => $this->updateRequest->errors(),
                    'roles' => $roles,
                    'admin' => $admin,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "admin/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            $payload['image'] = $this->updateRequest->file('image');
            clearOldInput(['email', 'name', 'phone', 'bio', 'address', 'birthday', 'image', 'role_id']);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/admins/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $admin = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá người dùng", 'body' => "admin/delete", 'admin' => $admin]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $admin = $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/admins/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}