<?php
namespace App\Http\Controllers\Dashboard\Product;

use App\Http\Controllers\Dashboard\BaseController;
use App\Http\Repositories\Interfaces\BrandProductRepositoryInterface as BrandProductRepository;
use App\Http\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Http\Repositories\Interfaces\UnitProductRepositoryInterface as UnitProductRepository;
use App\Http\Request\Product\CreateRequest;
use App\Http\Request\Product\UpdateRequest;
use App\Http\Services\Interfaces\Product\ProductServiceInterface as ProductService;
use App\Traits\HasRender;
use App\Traits\Loggable;

class ProductController extends BaseController
{
    use Loggable, HasRender;
    protected ProductService $productService;
    protected ProductCatalogueRepository $productCatalogueRepository;
    protected ProductVariantRepository $productVariantRepository;
    protected UnitProductRepository $unitProductRepository;
    protected BrandProductRepository $brandProductRepository;
    protected CreateRequest $storeRequest;
    protected UpdateRequest $updateRequest;
    public function __construct(
        ProductService $productService,
        ProductCatalogueRepository $productCatalogueRepository,
        ProductVariantRepository $productVariantRepository,
        UnitProductRepository $unitProductRepository,
        BrandProductRepository $brandProductRepository,
    )
    {
        $this->productService = $productService;
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->unitProductRepository = $unitProductRepository;
        $this->brandProductRepository = $brandProductRepository;
        parent::__construct($productService);
    }

    public function index()
    {
        try {
            $products = $this->baseIndex();
            $productCatalogues = $this->productCatalogueRepository->all()['data'];
            withInput([
                'keyword' => $_GET['keyword'] ?? "",
                'perpage' => $_GET['perpage'] ?? 10,
                'sort' => $_GET['sort'] ?? 1,
                'publish' => $_GET['publish'] ?? 1,
                'product_catalogue_id' => $_GET['product_catalogue_id'] ?? 0,
            ]);
            clearOldInput();
            $this->view('index', [
                'title' => "Quản lý sản phẩm",
                'body' => "product/index", 'products' => $products,
                'productCatalogues' => $productCatalogues,
            ]);
        } catch (\Exception $e){
            $this->handleLogException($e); die();
        }
    }

    public function create(): void
    {
        $productCatalogues = $this->productCatalogueRepository->all()['data'];
        $brands = $this->brandProductRepository->all()['data'];
        $this->view('index', [
            'title' => "Tạo sản phẩm",
            'body' => "product/store",
            'productCatalogues' => $productCatalogues,
            'brands' => $brands,
        ]);
    }

    public function show(int $id = null): void
    {
        try {
            $product = $this->baseShow($id);
            $productCatalogues = $this->productCatalogueRepository->all()['data'];
            $units = $this->productVariantRepository->findByProductId($id);
            $unit_products = $this->unitProductRepository->all()['data'];
            $brands = $this->brandProductRepository->all()['data'];
            $this->view('index', [
                'title' => "Cập nhật sản phẩm",
                'body' => "product/store",
                'product' => $product,
                'productCatalogues' => $productCatalogues,
                'units' => $units,
                'unit_products' => $unit_products,
                'brands' => $brands,
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
                    'description' => $this->storeRequest->input('description'),
                    'content' => $this->storeRequest->input('content'),
                    'meta_title' => $this->storeRequest->input('meta_title'),
                    'meta_keyword' => $this->storeRequest->input('meta_keyword'),
                    'meta_description' => $this->storeRequest->input('meta_description'),
                    'image' => $this->storeRequest->input('image'),
                    'album' => $this->storeRequest->input('album'),
                    'publish' => $this->storeRequest->input('publish'),
                    'product_catalogue_id' => $this->storeRequest->input('product_catalogue_id'),
                    'brand_product_id' => $this->storeRequest->input('brand_product_id'),
                    'variant_id' => $this->storeRequest->input('variant_id'),
                    'unit_id' => $this->storeRequest->input('unit_id'),
                    'sku' => $this->storeRequest->input('sku'),
                    'price' => $this->storeRequest->input('price'),
                    'stock' => $this->storeRequest->input('stock'),
                    'discount' => $this->storeRequest->input('discount'),
                    'start_date' => $this->storeRequest->input('start_date'),
                    'end_date' => $this->storeRequest->input('end_date'),
                ]);
                $productCatalogues = $this->productCatalogueRepository->all()['data'];
                $brands = $this->brandProductRepository->all()['data'];
                $unit_products = $this->unitProductRepository->all()['data'];
                $this->view('index', [
                    'body' => "product/store",
                    'errors' => $this->storeRequest->errors(),
                    'productCatalogues' => $productCatalogues,
                    'brands' => $brands,
                    'unit_products' => $unit_products,
                ]);
                die();
            };
            if(!$payload = $this->storeRequest->validated()){
                $this->view('index', ['body' => "product/store",'errors' => $this->storeRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'description',
                'content',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'album',
                'publish',
                'product_catalogue_id',
                'brand_product_id',
                'variant_id',
                'unit_id',
                'sku',
                'price',
                'stock',
                'discount',
                'start_date',
                'end_date',
            ]);
            $this->baseSave($payload);
            redirect('success', '', 'Thêm mới bản ghi thành công', '/dashboard/products/index');
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
                    'description' => $this->updateRequest->input('description'),
                    'content' => $this->updateRequest->input('content'),
                    'meta_title' => $this->updateRequest->input('meta_title'),
                    'meta_keyword' => $this->updateRequest->input('meta_keyword'),
                    'meta_description' => $this->updateRequest->input('meta_description'),
                    'image' => $this->updateRequest->input('image'),
                    'album' => $this->updateRequest->input('album'),
                    'publish' => $this->updateRequest->input('publish'),
                    'product_catalogue_id' => $this->updateRequest->input('product_catalogue_id'),
                    'brand_id' => $this->updateRequest->input('brand_id'),
                    'variant_id' => $this->updateRequest->input('variant_id'),
                    'unit_id' => $this->updateRequest->input('unit_id'),
                    'sku' => $this->updateRequest->input('sku'),
                    'price' => $this->updateRequest->input('price'),
                    'stock' => $this->updateRequest->input('stock'),
                    'discount' => $this->updateRequest->input('discount'),
                    'start_date' => $this->updateRequest->input('start_date'),
                    'end_date' => $this->updateRequest->input('end_date'),
                ]);
                $product = $this->baseShow($id);
                $productCatalogues = $this->productCatalogueRepository->all()['data'];
                $units = $this->productVariantRepository->findByProductId($id);
                $unit_products = $this->unitProductRepository->all()['data'];
                $brands = $this->brandProductRepository->all()['data'];
                $this->view('index', [
                    'body' => "product/store",
                    'errors' => $this->updateRequest->errors(),
                    'product' => $product,
                    'productCatalogues' => $productCatalogues,
                    'units' => $units,
                    'unit_products' => $unit_products,
                    'brands' => $brands,
                ]);
                die();
            }

            if(!$payload = $this->updateRequest->validated()){
                $this->view('index', ['body' => "product/store",'errors' => $this->updateRequest->errors()]);
                die();
            }
            clearOldInput([
                'name',
                'canonical',
                'description',
                'content',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'image',
                'album',
                'publish',
                'product_catalogue_id',
                'brand_id',
                'variant_id',
                'unit_id',
                'sku',
                'price',
                'stock',
                'discount',
                'start_date',
                'end_date',
            ]);
            $this->baseSave($payload, $id);
            redirect('success', '', 'Cập nhật bản ghi thành công', '/dashboard/products/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    public function delete(int $id = null): void
    {
        try {
            $product = $this->baseShow($id);
            $this->view('index', ['title' => "Xoá sản phẩm", 'body' => "product/delete", 'product' => $product]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
    public function destroy(int $id = null): void
    {
        try {
            $this->baseDelete($id);
            redirect('success', '', 'Xoá bản ghi thành công', '/dashboard/products/index');
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }
}