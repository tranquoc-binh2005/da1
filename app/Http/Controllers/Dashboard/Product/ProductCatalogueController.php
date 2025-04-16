<?php
namespace App\Http\Controllers\Dashboard\Product;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Http\Request\ProductCatalogue\CreateRequest;
use App\Http\Request\ProductCatalogue\UpdateRequest;
use App\Http\Services\Interfaces\Product\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class ProductCatalogueController extends BaseController
{
    use Loggable, HasRender;
    protected ProductCatalogueService $productCatalogueService;
    protected ProductCatalogueRepository $productCatalogueRepository;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        ProductCatalogueService $productCatalogueService,
        ProductCatalogueRepository $productCatalogueRepository,
    )
    {
        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
        parent::__construct($productCatalogueService);
    }

    public function index()
    {
        try {
            $productCatalogues = $this->baseIndex();
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
            ]);
            clearOldInput();
            $this->view('index', ['title' => "Quản lý danh mục sản phẩm", 'body' => "productCatalogue/index", 'productCatalogues' => $productCatalogues]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $productCatalogues = $this->productCatalogueRepository->all()['data'];
        $this->view('index', ['title' => "Tạo danh mục sản phẩm", 'productCatalogues' => $productCatalogues, 'body' => "productCatalogue/store"]);
    }

    public function show(int $id = null): void
    {
        try {
            $productCatalogue = $this->baseShow($id);
            $productCatalogues = $this->productCatalogueRepository->all()['data'];
            $this->view('index', [
                'title' => "Cập nhật danh mục sản phẩm",
                'body' => "productCatalogue/store",
                'productCatalogue' => $productCatalogue,
                'productCatalogues' => $productCatalogues
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
                    'canonical' => $this->storeRequest->input('canonical'),
                    'parent_id' => $this->storeRequest->input('parent_id'),
                    'description' => $this->storeRequest->input('description'),
                    'meta_title' => $this->storeRequest->input('meta_title'),
                    'meta_keyword' => $this->storeRequest->input('meta_keyword'),
                    'meta_description' => $this->storeRequest->input('meta_description'),
                    'image' => $this->storeRequest->input('image'),
                    'publish' => $this->storeRequest->input('publish'),
                ]);
                $this->view('index', ['body' => "productCatalogue/store",'errors' => $this->storeRequest->errors()]);
                die();
            }

            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "productCatalogue/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'parent_id',
                'description',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'publish',
            ]);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/product_catalogues/index');
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
                    'canonical' => $this->updateRequest->input('canonical'),
                    'parent_id' => $this->updateRequest->input('parent_id'),
                    'description' => $this->updateRequest->input('description'),
                    'meta_title' => $this->updateRequest->input('meta_title'),
                    'meta_keyword' => $this->updateRequest->input('meta_keyword'),
                    'meta_description' => $this->updateRequest->input('meta_description'),
                    'image' => $this->updateRequest->input('image'),
                    'publish' => $this->updateRequest->input('publish'),
                ]);
                $postCatalogue = $this->baseShow($id);
                $productCatalogues = $this->productCatalogueRepository->all()['data'];
                $this->view('index', [
                    'body' => "productCatalogue/store",
                    'errors' => $this->updateRequest->errors(),
                    'postCatalogue' => $postCatalogue,
                    'productCatalogues' => $productCatalogues,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "productCatalogue/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'parent_id',
                'description',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'publish',
            ]);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/product_catalogues/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $admin = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá danh mục sản phẩm", 'body' => "productCatalogue/delete", 'admin' => $admin]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/product_catalogues/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}