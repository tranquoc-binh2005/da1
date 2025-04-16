<?php
namespace App\Http\Controllers\Dashboard\Product;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Request\BrandProduct\CreateRequest;
use App\Http\Request\BrandProduct\UpdateRequest;
use App\Http\Services\Interfaces\Product\BrandProductServiceInterface as BrandProductService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class BrandProductController extends BaseController
{
    use Loggable, HasRender;
    protected BrandProductService $brandProductService;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        BrandProductService $brandProductService,
    )
    {
        $this->brandProductService = $brandProductService;
        parent::__construct($brandProductService);
    }

    public function index()
    {
        try {
            $brands = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý thương hiệu", 'body' => "brandProduct/index", 'brands' => $brands]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $this->view('index', ['title' => "Tạo thương hiệu", 'body' => "brandProduct/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $brand = $this->baseShow($id);
            $this->view('index', [
                'title' => "Cập nhật thương hiệu",
                'body' => "brandProduct/store",
                'brand' => $brand,
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
                $this->view('index', [
                    'body' => "brandProduct/store",
                    'errors' => $this->storeRequest->errors(),
                    'title' => "Thêm thương hiệu"
                ]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "brandProduct/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'value',
                'unit',
            ]);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/brand_products/index');
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
                $brand = $this->baseShow($id);
                $this->view('index', [
                    'body' => "brandProduct/store",
                    'errors' => $this->updateRequest->errors(),
                    'brand' => $brand,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "brandProduct/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'value',
                'unit',
            ]);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/brand_products/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $brand = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá thương hiệu", 'body' => "brandProduct/delete", 'brand' => $brand]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/brand_products/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}