<?php
namespace App\Http\Controllers\Dashboard\Auth;

use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Auth\AuthenticateRepository;
use App\Http\Request\Auth\StoreRequest;
use App\Http\Request\User\Register as UserStoreRequest;
use App\Http\Services\Interfaces\Auth\AuthenticateServiceInterface as AuthenticateService;
use App\Traits\HasAlert;
use App\Traits\HasRender;
use App\Traits\Loggable;

class AuthenticateController extends BaseController
{
    use HasRender, HasAlert, Loggable;
    protected StoreRequest $request;
    protected UserStoreRequest $userRequest;
    protected AuthenticateService $authenticateService;
    protected AuthenticateRepository $authenticateRepository;
    public function __construct(
        AuthenticateService $authenticateService,
        AuthenticateRepository $authenticateRepository,
    )
    {
        $this->authenticateService = $authenticateService;
        $this->authenticateRepository = $authenticateRepository;
        parent::__construct($authenticateService);
    }
    public function authenticate(): void
    {
        try {
            $this->request = new StoreRequest();
            if ($this->request->fails()) {
                withInput([
                    'email' => $this->request->input('email')
                ]);
                $this->view('auth/login', ['errors' => $this->request->errors()]);
                die();
            }

            if(!$payload = $this->request->validated()){
                $this->view('auth/login', ['errors' => $this->request->errors()]);
                die();
            }
            clearOldInput(['email']);
            if($this->authenticateService->login($payload) === false) {
                $this->view('index', ['title' => "Trang quản trị hệ thống", 'body' => "auth/login"])->with('error', '', 'Đăng nhập thất bại');
            }
            redirect('success', '', 'Đăng nhập thành công', '/dashboard');
            die();
        } catch (ModelNotFoundException $e){
            redirect('error', '', $e->getMessage(), '/auth/login');
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function register(): void
    {
        $this->view('auth/register');
    }

    public function handleRegister(): void
    {
        try {
            $this->userRequest = new UserStoreRequest();
            if ($this->userRequest->fails()) {
                withInput([
                    'email' => $this->userRequest->input('email'),
                    'name' => $this->userRequest->input('name'),
                ]);
                $this->view('auth/register', ['errors' => $this->userRequest->errors()]);
                die();
            }

            if(!$payload = $this->userRequest->validated()){
                $this->view('auth/register', ['errors' => $this->userRequest->errors()]);
                die();
            }
            clearOldInput(['email', 'email']);
            $this->baseSave($payload);
            $this->view('auth/login')->with('success', '', 'Đăng ký tài khoản thành công');
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function login(): void
    {
        $this->view('auth/login');
    }

    public function logout(): void
    {
        try {
            $this->authenticateService->logout();
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function revoke(): void
    {
        try {
            $this->authenticateService->revokeForce();
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }
}