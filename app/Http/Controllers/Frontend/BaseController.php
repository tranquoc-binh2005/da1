<?php
namespace App\Http\Controllers\Frontend;

use App\Models\Database;
use App\Http\Repositories\Product\ProductCatalogueRepository;
use App\Http\Repositories\Product\ProductVariantRepository;
use App\Http\Repositories\Cart\CartItemRepository;
use App\Traits\Loggable;
use App\Traits\HasRender;
use App\Http\Services\Impl\Cart\ClientCartService;
use App\ViewModel\frontend\CartItemViewModel;
class BaseController
{
    use Loggable, HasRender;
    protected string $dataHeader;
    protected array $dataCart;
    protected ProductCatalogueRepository $productCatalogueRepository;
    protected ProductVariantRepository $productVariantRepository;
    protected CartItemRepository $cartItemRepository;
    protected ClientCartService $clientCartService;
    protected CartItemViewModel $cartItemViewModel;
    protected Database $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->productCatalogueRepository = new ProductCatalogueRepository($this->database);
        $this->productVariantRepository = new ProductVariantRepository($this->database);
        $this->cartItemRepository = new CartItemRepository($this->database);
        $this->clientCartService = new ClientCartService();
        $this->cartItemViewModel = new CartItemViewModel();

        $categories = $this->productCatalogueRepository->all()['data'];
        $this->dataHeader = $this->buildMenu($categories, 0);
        $this->dataCart = $this->clientCartService->callCart();
    }

    private function buildMenu($categories, $parentId = 0): string
    {
        $menu = '';
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $subMenu = $this->buildMenu($categories, $category['id']);

                if ($subMenu) {
                    $menu .= '<div class="dropdown dropdown-item">
                            <a href="/san-pham?product_catalogue_id=' . $category['id'] . '">' . $category['name'] . '</a>
                            <div class="dropdown-content">' . $subMenu . '</div>
                          </div>';
                } else {
                    $menu .= '<a href="/san-pham?product_catalogue_id=' . $category['id'] . '">' . $category['name'] . '</a>';
                }
            }
        }

        return $menu;
    }

    protected function buildRequest(array $filters = [], int $perpage = 10, string $sort = 'order,desc'): array
    {
        $request = [
            'perpage' => $_GET['perpage'] ?? $perpage,
            'keyword' => $_GET['keyword'] ?? '',
            'sort' => $_GET['sort'] ?? $sort,
            'page' => $_GET['page'] ?? 1,
        ];

        foreach ($filters as $key) {
            $request[$key] = $_GET[$key] ?? null;
        }
        return $request;
    }
}