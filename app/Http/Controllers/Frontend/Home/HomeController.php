<?php
namespace App\Http\Controllers\Frontend\Home;

use App\Http\Controllers\Frontend\BaseController;
use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Http\Resources\Product\ProductCatalogueResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductVariantResource;
use App\Http\Services\Interfaces\Post\PostServiceInterface as PostService;
use App\Http\Services\Interfaces\Product\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Http\Services\Interfaces\Product\ProductServiceInterface as ProductService;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\ViewModel\frontend\ProductViewModel;

class HomeController extends BaseController
{
    use HasRender, Loggable;

    protected string $dataHeader;
    protected array $dataCart;
    protected ProductService $productService;
    protected ProductCatalogueService $productCatalogueService;
    protected PostService $postService;
    protected \App\Http\Repositories\Product\ProductVariantRepository $productVariantRepository;
    protected ProductViewModel $productViewModel;

    public function __construct(
        ProductService $productService,
        ProductCatalogueService $productCatalogueService,
        ProductVariantRepository $productVariantRepository,
        PostService $postService,
        ProductViewModel $productViewModel,
    )
    {
        parent::__construct();
        $this->productService = $productService;
        $this->productCatalogueService = $productCatalogueService;
        $this->productVariantRepository = $productVariantRepository;
        $this->postService = $postService;
        $this->productViewModel = $productViewModel;
    }

    public function index()
    {
        try {
            $productsBestSellers = $this->callProductBestSeller();
            $outstandingProducts = $this->productViewModel->getVariantsProduct($this->callOutstandingProduct());
            $outstandingCategories = $this->callCategoriesProduct();
            $outstandingPosts = $this->callOutstandingPost();
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "home/home",
                'dataHeader' => $this->dataHeader,
                'outstandingProducts' => $outstandingProducts,
                'outstandingCategories' => $outstandingCategories,
                'outstandingPosts' => $outstandingPosts,
                'productsBestSellers' => $productsBestSellers,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
            ]);
        } catch (\Exception $e) {
            $this->handleLogException($e);
        }
    }

    /**
     * @throws \Exception
     */
    private function callOutstandingProduct(): array
    {
        $_GET = $this->buildRequest(['product_catalogue_id'], 8, "order,desc");
        $result = new ProductResource($this->productService->paginate($_GET)['data']);
        return $result->toArray();
    }

    /**
     * @throws \Exception
     */
    private function callCategoriesProduct(): array
    {
        $_GET = $this->buildRequest([], 10, "order,desc");
        $result = new ProductCatalogueResource($this->productCatalogueService->paginate($_GET)['data']);
        return $result->toArray();
    }

    /**
     * @throws \Exception
     */
    private function callOutstandingPost(): array
    {
        $_GET = $this->buildRequest([], 4, "order,desc");
        $result = new ProductResource($this->postService->paginate($_GET)['data']);
        return $result->toArray();
    }

    /**
     * @throws \Exception
     */
    private function callProductBestSeller(): array
    {
        return $this->productViewModel->buildProductsBestSeller();
    }
}