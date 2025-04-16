<?php
namespace App\Http\Services\Impl\Auth;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\Interfaces\AdminRepositoryInterface as AdminRepository;
use App\Http\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Auth\AuthenticateServiceInterface;
use App\Models\Authenticate;
use App\Traits\HasAlert;
use App\Traits\HasRender;

class AuthenticateService extends BaseService implements AuthenticateServiceInterface
{
    use HasAlert, HasRender;
    protected AdminRepository $adminRepository;
    protected UserRepository $userRepository;
    protected Authenticate $authenticateModel;
    protected array $admin;
    public function __construct(
        AdminRepository $adminRepository,
        UserRepository $userRepository,
    )
    {
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->authenticateModel = new Authenticate();
        parent::__construct($adminRepository, $this->authenticateModel);
    }

    /**
     * @throws \Exception
     */
    public function login(array $credentials): bool
    {
        return $this->attemp($credentials);
    }

    /**
     * @throws \Exception
     */
    private function attemp(array $credentials): bool
    {
        try {
            if (!$this->admin = $this->adminRepository->findByEmail($credentials['email'])) {
                $this->with('error', 'Thất bại', 'Vui lòng kiểm tra lại tài khoản hoặc mật khẩu');
                return false;
            }
            if (password_verify($credentials['password'], $this->admin['password'])) {
                $_SESSION['admin'] = $this->admin;
                return true;
            }
            return false;
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function prepareModelData(array $payload = []): self
    {
        $payload['admin_id'] = $_SESSION['user']['id'] ?? null;
        if (isset($payload['password']) && !password_get_info($payload['password'])['algo']) {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        }
        $this->payload = $payload;
        return $this;
    }

    public function register(array $payload): bool
    {
        try {
            return $this->adminRepository->create($payload);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function logout(): void
    {
        unset($_SESSION['admin']);
        $this->view('auth/login')->with('success', 'Thành công', 'Đăng xuất thành công!');
    }

    public function revokeForce(): void
    {
        unset($_SESSION['admin']);
        redirect('warning', '', 'Bạn đã bị thu hồi quyền', '/auth/login');
    }
}