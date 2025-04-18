<?php
namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Frontend\BaseController;
use App\Http\Resources\Product\ProductCatalogueResource;
use App\Http\Resources\Product\DetailProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Services\Interfaces\Product\ProductServiceInterface as ProductService;
use App\Http\Services\Interfaces\Product\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Traits\HasRender;
use App\Traits\Loggable;
use App\ViewModel\frontend\ProductViewModel;
use App\ViewModel\frontend\ProductCatalogueViewModel;

class ProductController extends BaseController
{
    use HasRender, Loggable;
    protected string $dataHeader;
    protected ProductService $productService;
    protected ProductCatalogueService $productCatalogueService;
    protected ProductViewModel $productViewModel;
    protected ProductCatalogueViewModel $productCatalogueViewModel;

    public function __construct(
        ProductService $productService,
        ProductCatalogueService $productCatalogueService,
        ProductViewModel $productViewModel,
        ProductCatalogueViewModel $productCatalogueViewModel,
    )
    {
        parent::__construct();
        $this->productService = $productService;
        $this->productCatalogueService = $productCatalogueService;
        $this->productViewModel = $productViewModel;
        $this->productCatalogueViewModel = $productCatalogueViewModel;
    }

    public function index()
    {
        try {
            $productsBestSellers = $this->callProductBestSeller();
            $products = $this->callListProducts();
            $categories = $this->callListCategories();
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "product/home",
                'dataHeader' => $this->dataHeader,
                'products' => $products,
                'categories' => $categories,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'productsBestSellers' => $productsBestSellers,
            ]);
            $this->render('frontend/index', ['title' => "Hạt Vàng Organic", 'body' => "product/home"]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }


    public function detail($canonical): void
    {
        try {
            $product = $this->callDetailProduct($canonical);
            $this->buildRecentlyProduct($product);
            $this->render('frontend/index', [
                'title' => "Hạt Vàng Organic",
                'body' => "product/detail",
                'dataHeader' => $this->dataHeader,
                'dataCart' => [
                    'cart' => $this->dataCart,
                    'total' => $this->cartItemViewModel->totalCart($this->dataCart),
                ],
                'product' => $product,
            ]);
        } catch (\Exception $e){
            $this->handleLogException($e);
        }
    }

    private function buildRecentlyProduct(array $product): void
    {
        if(isset($_SESSION['recentlyProduct'][$product['canonical']])){
            unset($_SESSION['recentlyProduct'][$product['canonical']]);
        }

        $_SESSION['recentlyProduct'][$product['canonical']] = $product;
        if (count($_SESSION['recentlyProduct']) > 10)  $_SESSION['recentlyProduct'] = array_slice($_SESSION['recentlyProduct'], -10);
    }

    /**
     * @throws \Exception
     */
    private function callListCategories(): array
    {
        $_GET = $this->buildRequest([], 0, "order,desc");
        $result = new ProductCatalogueResource($this->productCatalogueService->all()['data']);
        return $this->productCatalogueViewModel->buildCountProducts($result->toArray());
    }

    /**
     * @throws \Exception
     */
    private function callListProducts(): array
    {
        $_GET = $this->buildRequest(['product_catalogue_id'], 9, "id,desc");
        $paginationProducts = $this->productService->paginate($_GET);

        $result = $this->productViewModel->buildNavigation($paginationProducts);
        $result['data'] = $this->productViewModel->buildVariantsProduct($result['data']);
        return $result;
    }

    /**
     * @throws \Exception
     */
    private function callDetailProduct(string $canonical): array
    {
        $product = $this->productService->findByCanonical($canonical);
        $product = $this->productViewModel->buildVariantsProduct($product);
        $product = $this->productViewModel->buildRatingProduct($product);
        $product = new DetailProductResource($product);
        return $product->toArray();
    }

    /**
     * @throws \Exception
     */
    private function callProductBestSeller(): array
    {
        return $this->productViewModel->buildProductsBestSeller();
    }
}