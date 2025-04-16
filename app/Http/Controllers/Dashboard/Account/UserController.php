<?php
namespace App\Http\Controllers\Dashboard\Account;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Request\User\CreateRequest as UserCreateRequest;
use App\Http\Request\User\UpdateRequest;
use App\Http\Services\Interfaces\Account\UserServiceInterface as UserService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class UserController extends BaseController
{
    use Loggable, HasRender;
    protected UserService $userService;
    protected UserCreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        UserService $userService,
    )
    {
        $this->userService = $userService;
        parent::__construct($userService);
    }

    public function index()
    {
        try {
            $users = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'publish' => $_GET['publish'] ?? 1,
                'sort' => $_GET['sort'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý người dùng", 'body' => "user/index", 'users' => $users]);
        } catch (\Exception $e){
            $this->handleLogException($e, $message = "loi"); die();
        }
    }

    public function create(): void
    {
        $this->view('index', ['title' => "Tạo người dùng", 'body' => "user/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $user = $this->baseShow($id);
            $this->view('index', ['title' => "Cập nhật người dùng", 'body' => "user/store", 'user' => $user]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function store(): void
    {
        try {
            $this->storeRequest = new UserCreateRequest();
            if ($this->storeRequest->fails()) {
                withInput([
                    'email' => $this->storeRequest->input('email'),
                    'name' => $this->storeRequest->input('name'),
                    'phone' => $this->storeRequest->input('phone'),
                    'bio' => $this->storeRequest->input('bio'),
                    'address' => $this->storeRequest->input('address'),
                    'birthday' => $this->storeRequest->input('birthday'),
                    'image' => $this->storeRequest->input('image'),
                ]);
                $this->view('index', ['body' => "admin/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "admin/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            $payload['image'] = $this->storeRequest->file('image');
            clearOldInput(['email', 'name', 'phone', 'bio', 'address', 'birthday', 'image']);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/admins/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function update(int $id): void
    {
        try {
            $this->updateRequest = new UpdateRequest();
            if ($this->updateRequest->fails()) {
                withInput([
                    'email' => $this->updateRequest->input('email'),
                    'name' => $this->updateRequest->input('name'),
                    'phone' => $this->updateRequest->input('phone'),
                    'bio' => $this->updateRequest->input('bio'),
                    'address' => $this->updateRequest->input('address'),
                    'birthday' => $this->updateRequest->input('birthday'),
                    'user_catalogue_id' => $this->updateRequest->input('user_catalogue_id'),
                    'image' => $this->updateRequest->input('image'),
                ]);
                $user = $this->baseShow($id);
                $this->view('index', [
                    'body' => "user/store",
                    'errors' => $this->updateRequest->errors(),
                    'user' => $user,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "user/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput(['email', 'name', 'phone', 'bio', 'address', 'birthday', 'user_catalogue_id', 'image']);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/users/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $user = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá người dùng", 'body' => "user/delete", 'user' => $user]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $user = $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/users/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}