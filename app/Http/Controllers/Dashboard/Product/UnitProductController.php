<?php
namespace App\Http\Controllers\Dashboard\Product;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Request\UnitProduct\CreateRequest;
use App\Http\Request\UnitProduct\UpdateRequest;
use App\Http\Services\Interfaces\Product\UnitProductServiceInterface as UnitProductService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class UnitProductController extends BaseController
{
    use Loggable, HasRender;
    protected UnitProductService $unitProductService;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        UnitProductService $unitProductService,
    )
    {
        $this->unitProductService = $unitProductService;
        parent::__construct($unitProductService);
    }

    public function index()
    {
        try {
            $unitProducts = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý đơn vị khối lượng", 'body' => "unitProduct/index", 'unitProducts' => $unitProducts]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $this->view('index', ['title' => "Tạo đơn vị khối lượng", 'body' => "unitProduct/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $unit = $this->baseShow($id);
            $this->view('index', [
                'title' => "Cập nhật đơn vị khối lượng",
                'body' => "unitProduct/store",
                'unit' => $unit,
            ]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function store(): void
    {
        try {
            $this->storeRequest = new CreateRequest();
            if ($this->storeRequest->fails()) {
                withInput([
                    'name' => $this->storeRequest->input('name'),
                    'value' => $this->storeRequest->input('value'),
                    'unit' => $this->storeRequest->input('unit'),
                ]);
                $this->view('index', ['body' => "unitProduct/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "unitProduct/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'value',
                'unit',
            ]);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/unit_products/index');
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
                    'value' => $this->updateRequest->input('value'),
                    'unit' => $this->updateRequest->input('unit'),
                ]);
                $unit = $this->baseShow($id);
                $this->view('index', [
                    'body' => "unitProduct/store",
                    'errors' => $this->updateRequest->errors(),
                    'unit' => $unit,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "unitProduct/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'value',
                'unit',
            ]);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/unit_products/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $unit = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá đơn vị khối lượng", 'body' => "unitProduct/delete", 'unit' => $unit]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/unit_products/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}