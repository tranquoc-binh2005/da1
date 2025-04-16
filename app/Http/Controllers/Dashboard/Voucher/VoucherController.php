<?php
namespace App\Http\Controllers\Dashboard\Voucher;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Request\Voucher\CreateRequest;
use App\Http\Request\Voucher\UpdateRequest;
use App\Http\Services\Interfaces\Voucher\VoucherServiceInterface as VoucherService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class VoucherController extends BaseController
{
    use Loggable, HasRender;
    protected VoucherService $voucherService;
    protected CreateRequest $createRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        VoucherService $voucherService,
    )
    {
        $this->voucherService = $voucherService;
        parent::__construct($voucherService);
    }

    public function index()
    {
        try {
            $vouchers = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'publish' => $_GET['publish'] ?? 1,
                'sort' => $_GET['sort'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý voucher giảm giá", 'body' => "voucher/index", 'vouchers' => $vouchers]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $this->view('index', ['title' => "Tạo voucher giảm giá", 'body' => "voucher/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $voucher = $this->baseShow($id);
            $this->view('index', ['title' => "Cập nhật voucher giảm giá", 'body' => "voucher/store", 'voucher' => $voucher]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function store(): void
    {
        try {
            $this->createRequest = new CreateRequest();
            if ($this->createRequest->fails()) {
                withInput([
                    'name' => $this->createRequest->input('name'),
                    'description' => $this->createRequest->input('description'),
                    'value' => $this->createRequest->input('value'),
                    'min' => $this->createRequest->input('min'),
                    'max' => $this->createRequest->input('max'),
                    'start_at' => $this->createRequest->input('start_at'),
                    'dead_at' => $this->createRequest->input('dead_at'),
                ]);
                $this->view('index', ['body' => "voucher/store",'errors' => $this->createRequest->errors()]);
                die();
            }
            if(!$payload = $this->createRequest->validated()){
                $this->view('index', ['body' => "voucher/store",'errors' => $this->createRequest->errors()]);
                die();
            }
            clearOldInput(['name', 'description', 'value', 'min', 'max', 'start_at', 'dead_at']);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/vouchers/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function update(int $id): void
    {
        try {
            $this->updateRequest = new UpdateRequest($id);
            if ($this->updateRequest->fails()) {
                withInput([
                    'name' => $this->updateRequest->input('name'),
                    'description' => $this->updateRequest->input('description'),
                    'value' => $this->updateRequest->input('value'),
                    'min' => $this->updateRequest->input('min'),
                    'max' => $this->updateRequest->input('max'),
                    'start_at' => $this->updateRequest->input('start_at'),
                    'dead_at' => $this->updateRequest->input('dead_at'),
                ]);
                $user = $this->baseShow($id);
                $this->view('index', [
                    'body' => "voucher/store",
                    'errors' => $this->updateRequest->errors(),
                    'user' => $user,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "voucher/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput(['name', 'description', 'value', 'min', 'max', 'start_at', 'dead_at']);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/vouchers/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $voucher = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá voucher giảm giá", 'body' => "voucher/delete", 'voucher' => $voucher]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/vouchers/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}