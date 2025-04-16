<?php
namespace App\ViewModel\frontend;

use App\Exceptions\ModelNotFoundException;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductVariantResource;
use App\Http\Repositories\Voucher\VoucherRepository;
use App\Http\Resources\Voucher\VoucherResource;
use App\Models\Database;
use App\Traits\Str;
class CheckoutViewModel
{
    use Str;
    protected VoucherRepository $voucherRepository;
    protected Database $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->voucherRepository = new VoucherRepository($this->database);
    }

    public function checkVoucher(int $total): array
    {
        try {
            $errors = [];

            if (!$voucherCode = $_POST['voucher']) return [];

            if (!$voucher = $this->voucherRepository->findByName($voucherCode)) {
                $errors[] = 'Mã giảm giá không tồn tại.';
                return ['errors' => $errors];
            }

            $voucher = new VoucherResource($voucher);
            $voucherData = $voucher->toArray();
            $now = date('Y-m-d H:i:s');

            if ($voucherData['quantity'] <= 0) $errors[] = 'Mã giảm giá đã hết lượt sử dụng.';
            if ($voucherData['start_at'] > $now) $errors[] = 'Mã giảm giá chưa bắt đầu áp dụng.';
            if ($voucherData['dead_at'] < $now) $errors[] = 'Mã giảm giá đã hết hạn.';
            if ($total < $voucherData['min']) $errors[] = 'Đơn hàng của bạn chưa đạt mức tối thiểu để áp dụng mã.';

            if (!empty($errors)) return ['errors' => $errors];

            $discount = floor($total * $voucherData['value'] / 100);
            if ($discount > $voucherData['max']) {
                $discount = $voucherData['max'];
            }

            $totalAfterDiscount = max($total - $discount, 0); // tránh âm tiền

            return [
                'voucher' => $voucherData['name'],
                'discount_amount' => $discount,
                'total_after_discount' => $totalAfterDiscount,
                'message' => 'Áp dụng mã thành công!'
            ];
        } catch (ModelNotFoundException|\Exception $exception) {
            return ['errors' => ['Mã giảm giá không tồn tại.']];
        }
    }
}