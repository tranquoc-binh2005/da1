<?php
namespace App\Http\Controllers\Ajax;

use App\Http\Repositories\Interfaces\ProductRatingRepositoryInterface as RatingProductRepository;
use App\Http\Controllers\Ajax\BaseAjaxController;
class RatingController extends BaseAjaxController
{
    protected RatingProductRepository $ratingProductRepository;

    public function __construct(RatingProductRepository $ratingProductRepository)
    {
        $this->ratingProductRepository = $ratingProductRepository;
    }

    public function rating(): void
    {
        header('Content-Type: application/json');
        try {
            if(!$this->isLogin()){
                echo json_encode(['status' => false, 'message' => "Vui lòng đăng nhập để bình luận", 'isLogin' => false]);
                exit();
            }
            $payload = $this->prepareRatingData();
            if (!$this->ratingProductRepository->saveRatingProduct($payload)) {
                echo json_encode(['status' => false, 'message' => "Đã có lỗi xảy ra, vui lòng thử lại"]);
                exit();
            }
            echo json_encode(['status' => true, 'message' => "Bình luận cho sản phẩm thành công"]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            throw $e;
        }
    }

    private function prepareRatingData(): array
    {
        $user = $this->isLogin();
        return [
            'rating' => $_POST['data']['rating'],
            'rating_text' => $this->prepareRatingText(),
            'customer_name' => $_POST['data']['name'],
            'customer_email' => $_POST['data']['email'],
            'customer_content' => $_POST['data']['content'],
            'product_id' => $_POST['data']['product_id'],
            'user_id' => $user['id'],
        ];
    }

    private function prepareRatingText(): string
    {
        $rating = $_POST['data']['rating'];
        return match ((int)$rating) {
            1 => 'Quá tệ',
            2 => 'Cần cải thiện',
            3 => 'Tạm ổn',
            4 => 'Tốt',
            5 => 'Tuyệt vời',
            default => 'Không xác định',
        };
    }

}