<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
class ChangePassword
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function checkIsPassword()
    {
        header('Content-Type: application/json');
        try {
            $payload = [
                'password' => $_POST['data']['currentPassword'],
                'email' => $_SESSION['user']['email'],
            ];
            if(!$this->userRepository->checkIsPassword($payload)){
                echo json_encode(['status' => false, 'message' => "Mật khẩu hiện tại không chính xác"]);
                exit();
            }
            $data = [
                'new_password' => $_POST['data']['newPassword'],
                'email' => $_SESSION['user']['email'],
            ];
            if(!$this->userRepository->changePassword($data)){
                echo json_encode(['status' => false, 'message' => "Đã có lỗi xảy ra, vui lòng thử lại"]);
                exit();
            }
            echo json_encode(['status' => true, 'message' => "Cập nhật mật khẩu mới thành công"]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            throw $e;
        }
    }

}