<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Ajax\BaseAjaxController;
use App\Http\Repositories\Interfaces\AddressShoppingRepositoryInterface as AddressShoppingRepository;
class AddressShoppingController extends BaseAjaxController
{
    protected AddressShoppingRepository $addressShoppingRepository;
    public function __construct(
        AddressShoppingRepository $addressShoppingRepository
    )
    {
        $this->addressShoppingRepository = $addressShoppingRepository;
    }

    public function saveAddressShopping(): void
    {
        header('Content-Type: application/json');
        try {
            $payload = $this->prepareData();
            if(!$this->addressShoppingRepository->createAddressShopping($payload)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
            }
            $listAddressShopping = $this->addressShoppingRepository->getAllAddressShopping($payload['user_id']);
            echo json_encode(['status' => true, 'message' => "Thêm địa chỉ thành công", 'data' => $listAddressShopping]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    private function prepareData(): array
    {
        $user = $this->isLogin();
        return [
            'name' => $_POST['data']['fullName'],
            'address' => $_POST['data']['address'],
            'phone' => $_POST['data']['phone'],
            'isDefault' => $_POST['data']['isDefault'],
            'user_id' => $user['id'],
        ];
    }

    public function removeAddressShopping(): void
    {
        header('Content-Type: application/json');
        try {
            $id = $_POST['id'];
            $user = $this->isLogin();
            if(!$this->addressShoppingRepository->deleteAddressShopping($id)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
            }
            $listAddressShopping = $this->addressShoppingRepository->getAllAddressShopping($user['id']);
            echo json_encode(['status' => true, 'message' => "Xoá địa chỉ thành công", 'data' => $listAddressShopping]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function detailAddressShopping(): void
    {
        header('Content-Type: application/json');
        try {
            $user = $this->isLogin();
            $payload = [
                'id' => $_POST['id'],
                'user_id' => $user['id'],
            ];
            if(!$data = $this->addressShoppingRepository->detailAddressShopping($payload)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
            }
            echo json_encode(['status' => true, 'message' => "Trả dữ liệu thành công", 'data' => $data]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function updateAddressShopping(): void
    {
        header('Content-Type: application/json');
        try {
            $payload = $this->prepareData();
            $payload['addressId'] = $_POST['addressId'];
            
            if(!$this->addressShoppingRepository->updateAddressShopping($payload)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
                return;
            }
            
            $listAddressShopping = $this->addressShoppingRepository->getAllAddressShopping($payload['user_id']);
            echo json_encode([
                'status' => true, 
                'message' => "Cập nhật địa chỉ thành công", 
                'data' => $listAddressShopping
            ]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function changeAddressShopping(): void
    {
        header('Content-Type: application/json');
        try {
            $user = $this->isLogin();
            $payload = [
                'id' => $_POST['addressId'],
                'user_id' => $user['id'],
            ];

            if(!$address = $this->addressShoppingRepository->detailAddressShopping($payload)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
                return;
            }

            $_SESSION['addressDefault'] = $address;

            echo json_encode([
                'status' => true,
                'message' => "success",
                'address' => $address
            ]);
        } catch (\Exception $exception) {
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}