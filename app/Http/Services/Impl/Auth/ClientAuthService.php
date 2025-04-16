<?php
namespace App\Http\Services\Impl\Auth;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Auth\ClientAuthServiceInterface;
use App\Models\Authenticate;
use App\Traits\HasAlert;
use App\Traits\HasRender;
use App\Http\Services\Interfaces\Mail\RegisterAccountSendMailInterface as RegisterAccountSendMail;
use App\Http\Repositories\Interfaces\VerifyRepositoryInterface as VerifyRepository;

class ClientAuthService extends BaseService implements ClientAuthServiceInterface
{
    use HasAlert, HasRender;
    protected UserRepository $userRepository;
    protected Authenticate $authenticateModel;
    protected VerifyRepository $verifyRepository;
    protected RegisterAccountSendMail $registerAccountSendMail;
    protected const EXPRIRE_AT_VERIFY = 600;
    protected array $client;
    public function __construct(
        UserRepository $userRepository,
        RegisterAccountSendMail $registerAccountSendMail,
        VerifyRepository $verifyRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->registerAccountSendMail = $registerAccountSendMail;
        $this->verifyRepository = $verifyRepository;
        $this->authenticateModel = new Authenticate();
        parent::__construct($userRepository, $this->authenticateModel);
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
            if (!$this->client = $this->userRepository->findByEmail($credentials['email'])) {
                $this->with('error', 'Thất bại', 'Vui lòng kiểm tra lại tài khoản hoặc mật khẩu');
                return false;
            }
            if (password_verify($credentials['password'], $this->client['password'])) {
                $_SESSION['user'] = $this->client;
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
        if (isset($payload['password']) && !password_get_info($payload['password'])['algo']) {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        }
        $this->payload = $payload;
        return $this;
    }

    public function verify(array $payload): bool
    {
        try {
            $code = random_int(100000, 999999);
            $_SESSION['dataClient'][$code] = [
                'email' => $payload['email'],
                'password' => $this->hashPassword($payload['password']),
            ];
            $dataVerify = [
                'email' => $payload['email'],
                'expire_at' => self::EXPRIRE_AT_VERIFY,
                'code' => $code,
                'dead_at' => $this->dead_at()
            ];
            $content = "Xin chào, vui lòng xác nhận code để đăng ký tài khoản, code của bạn là <strong>{$code}</strong>";
            if($this->registerAccountSendMail->sendMailToClient($payload['email'], "Đăng ký tài khoản", $content, [])){
                return $this->verifyRepository->createVerify($dataVerify);
            }
            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function dead_at(int $time = self::EXPRIRE_AT_VERIFY): string
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y-m-d H:i:s', (time() + $time));
    }

    public function handleVerify(array $payload = []): bool
    {
        try {
            if(!$code = (int)implode('', $payload['code'])){
                return false;
            }
            if(!$this->verifyRepository->verify($code)) {
                return false;
            }
            if(!$this->verifyRepository->revoke($code)){
                return false;
            }
            if(!isset($_SESSION['dataClient'][$code])){
                return false;
            }
            if($id = $this->userRepository->createAccount($_SESSION['dataClient'][$code])){
                $_SESSION['user'] = $_SESSION['dataClient'][$code];
                $_SESSION['user']['id'] = $id;
                unset($_SESSION['dataClient'][$code]);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        redirect('success', '', 'Đăng xuất thành công!', '/trang-chu');
    }

    public function revokeForce(): void
    {
        unset($_SESSION['admin']);
        redirect('warning', '', 'Bạn đã bị thu hồi quyền', '/auth/login');
    }
}