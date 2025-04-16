<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Services\Interfaces\Account\UserServiceInterface as UserService;
class UserController
{
    protected UserService $userService;
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    /**
     * @throws \Exception
     */
    public function updateProfileUser(): void
    {
        header('Content-Type: application/json');
        try {
            $payload = $_POST['data'];
            if(!$this->userService->save($payload, $_SESSION['user']['id'])){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
            }
            $this->resetDataUser($payload);
            echo json_encode(['status' => true, 'message' => "Cập nhật thông tin thành công"]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    private function resetDataUser(array $dataUser): void
    {
        $dataUser = array_merge([
            'id' => $_SESSION['user']['id'],
        ], $dataUser);

        $_SESSION['user'] = $dataUser;
    }
}