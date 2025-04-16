<?php
namespace App\Http\Controllers\Ajax;

use App\Exceptions\ModelNotFoundException;
use App\Http\Repositories\Interfaces\VoucherRepositoryInterface as VoucherRepository;
class VoucherController
{
    protected VoucherRepository $voucherRepository;
    public function __construct(
        VoucherRepository $voucherRepository
    )
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function checkIsVoucher()
    {
        header('Content-Type: application/json');
        try {
            $voucher = $_POST['voucher'];
            if(!$voucher = $this->voucherRepository->findByName($voucher)){
                echo json_encode(['status' => false, 'message' => "Có lỗi xảy ra, vui lòng thử lại sau"]);
            }
            echo json_encode(['status' => true, 'message' => "success", 'data' => $voucher]);
        } catch (ModelNotFoundException|\Exception $exception){
            echo json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}