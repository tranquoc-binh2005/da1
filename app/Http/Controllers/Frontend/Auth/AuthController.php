<?php
namespace App\Http\Controllers\Frontend\Auth;

use App\Exceptions\ModelNotFoundException;
use App\Http\Request\Auth\ClientRegisterRequest;
use App\Http\Request\Auth\StoreRequest;
use App\Http\Services\Interfaces\Auth\ClientAuthServiceInterface as ClientAuthService;
use App\Traits\HasAlert;
use App\Traits\HasRender;
use App\Traits\Loggable;

class AuthController
{
    use HasRender, Loggable, HasAlert;

    protected ClientAuthService $clientAuthService;
    protected ClientRegisterRequest $clientRegisterRequest;
    protected StoreRequest $storeRequest;
    public function __construct(
        ClientAuthService $clientAuthService
    )
    {
        $this->clientAuthService = $clientAuthService;
    }

    public function login(): void
    {
        try {
            $this->render('frontend/auth/login', ['title' => "Đăng nhập"]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function handleLogin()
    {
        try {
            $this->storeRequest = new StoreRequest();
            if ($this->storeRequest->fails()) {
                withInput([
                    'email' => $this->storeRequest->input('email')
                ]);
                $this->render('frontend/auth/login', ['title' => "Đăng nhập", 'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->render('frontend/auth/login', ['title' => "Đăng nhập", 'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput(['email']);
            if($this->clientAuthService->login($payload) === false) {
                redirect('error', '', 'Đăng nhập thất bại, vui lòng kiểm tra lại mật khẩu', '/dang-nhap');
                die();
            }
            redirect('success', '', 'Đăng nhập thành công', '/trang-chu');
            die();
        } catch (ModelNotFoundException $e){
            redirect('error', '', 'Đăng nhập thất bại, vui lòng thử lại', '/dang-nhap');
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function register(): void
    {
        try {
            $this->render('frontend/auth/register', ['title' => "Đăng ký tài khoản"]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function handleRegister()
    {
        try {
            $this->clientRegisterRequest = new ClientRegisterRequest();
            if ($this->clientRegisterRequest->fails()) {
                withInput([
                    'email' => $this->clientRegisterRequest->input('email')
                ]);
                $this->render('frontend/auth/register', ['title' => "Đăng ký tài khoản", 'errors' => $this->clientRegisterRequest->errors()]);
                die();
            }

            if(!$payload = $this->clientRegisterRequest->validated()){
                $this->render('frontend/auth/login', ['title' => "Đăng ký tài khoản", 'errors' => $this->clientRegisterRequest->errors()]);
                die();
            }
            clearOldInput(['email']);
            if($this->clientAuthService->verify($payload) === false) {
                $this->render('frontend/auth/register', ['title' => "Đăng ký tài khoản", 'body' => "home/home"])->with('error', '', 'Có lỗi xảy ra vui lòng thử lại sau');
                die();
            }
            $this->render('frontend/auth/verify', ['title' => "Xác nhận mã OTP"]);
            die();
        } catch (ModelNotFoundException $e){
            $this->render('frontend/auth/register', ['title' => "Đăng ký tài khoản", 'body' => "home/home"])->with('error', '', 'Có lỗi xảy ra vui lòng thử lại sau');
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function handleVerify()
    {
        try {
            if(!$this->clientAuthService->handleVerify($_POST)){
                $this->render('frontend/auth/register', [
                    'title' => "Đăng kí tài khoản",
                ])->with('error', '', 'Đăng ký tài khoản không thành công, vui lòng thử lại sau');
                die();
            }

            redirect('success', '', 'Đăng ký tài khoản thành công', '/thong-tin-ca-nhan');
            die();
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function logout(): void
    {
        try {
            $this->clientAuthService->logout();
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    public function profile()
    {
        try {
            $this->render('frontend/index', ['title' => "Hạt Vàng Organic", 'body' => "profile/index"]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}