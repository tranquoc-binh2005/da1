<?php
namespace App\Http\Services\Impl\Product;

use App\Http\Repositories\Interfaces\BrandProductRepositoryInterface as BrandProductRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Product\BrandProductServiceInterface;
use App\Models\BrandProduct;
use App\Classes\Nested;
use App\Traits\HasHook;
use App\Traits\Str;

class BrandProductService extends BaseService implements BrandProductServiceInterface
{
    use HasHook, Str;
    protected BrandProductRepository $brandProductRepository;
    protected BrandProduct $brandProductModel;
    protected Nested $nested;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['admins'];

    protected const CACHE_KEY_PREFIX = 'unit_products';
    private const NESTED_SET_TABLE = 'unit_products';

    public function __construct(
        BrandProductRepository $brandProductRepository
    )
    {
        $this->brandProductRepository = $brandProductRepository;
        $this->brandProductModel = new BrandProduct();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($brandProductRepository, $this->brandProductModel);
    }

    public function specification($request): array
    {
        return [
            'type' => $request['type'] ?? '',
            'perpage' => $request['perpage'] ?? self::PER_PAGE,
            'sort' => !empty($request['sort']) ? explode(',', $request['sort']) : ['id', 'asc'],
            'keyword' => [
                'q' => $request['keyword'] ?? '',
                'field' => $this->fieldSearch
            ],
            'filters' => [
                'simple' => $this->buildFilter($request, $this->simpleFilter),
                'complex' => $this->buildFilter($request, $this->complexFilter),
                'date' => $this->buildFilter($request, $this->dateFilter),
            ],
            'with' => $this->with
        ];
    }

    public function prepareModelData(array $payload = []): self
    {
        $this->initializeBasicData($payload);
        return $this;
    }

    private function initializeBasicData(array $payload = []): void
    {
        $payload['admin_id'] = $_SESSION['admin']['id'];
        $this->payload = $payload;
    }
}