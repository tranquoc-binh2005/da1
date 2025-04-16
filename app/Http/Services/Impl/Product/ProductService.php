<?php
namespace App\Http\Services\Impl\Product;

use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface as ProductVariantRepository;
use App\Http\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Product\ProductServiceInterface;
use App\Models\Product;
use App\Classes\Nested;
use App\Traits\HasHook;
use App\Traits\Str;
use App\Models\ProductVariant;
use App\Http\Repositories\BaseRepository;

class ProductService extends BaseService implements ProductServiceInterface
{
    use HasHook, Str;
    protected ProductVariantRepository $productVariantRepository;
    protected ProductRepository $productRepository;
    protected $baseRepository;
    protected Product $productModel;
    protected ProductVariant $productVariantModel;
    protected Nested $nested;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name', 'tb1.description'];
    protected array $simpleFilter = ['tb1.publish', 'tb1.product_catalogue_id', 'tb1.canonical'];
    protected array $complexFilter = ['tb1.id', 'tb1.order'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['admins', 'product_catalogues', 'brand_products'];

    protected const CACHE_KEY_PREFIX = 'products';

    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->productModel = new Product();
        $this->productVariantModel = new ProductVariant();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($productRepository, $this->productModel);
    }

    public function specification($request): array
    {
        return [
            'type' => $request['type'] ?? '',
            'perpage' => $request['perpage'] ?? self::PER_PAGE,
            'sort' => !empty($request['sort']) ? explode(',', $request['sort']) : ['order', 'desc'],
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
        $payload['canonical'] = $this->convertStringToSlug($payload['canonical']);
        $payload['admin_id'] = $_SESSION['admin']['id'] ?? "";
        $payload['album'] = json_encode($payload['album'] ?? [], JSON_UNESCAPED_SLASHES);
        $this->payload = $payload;
    }

    public function save(array $payload = [], int $id = null): mixed
    {
        try {
            return $this
                ->beginTransaction()
                ->prepareModelData($payload)
                ->beforeSave()
                ->saveModel($id)
                ->commit()
                ->beginTransactionRelation()
                ->beforeRelationModel()
                ->saveRelationModel()
                ->commitRelation()
                ->afterSave($id)
                ->getResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function beforeRelationModel(): self
    {
        $this->payloadRelation = array_intersect_key($this->payload, array_flip($this->productVariantModel->fillAble()));
        return $this;
    }

    /**
     * @throws \Exception
     */
    private function saveRelationModel(): self{
        $this->productVariantRepository->saveVariant($this->result, $this->payloadRelation);
        return $this;
    }

    private function beginTransactionRelation(): self
    {
        $this->productVariantRepository->getBeginTransaction();
        return $this;
    }

    private function commitRelation(): self
    {
        $this->productVariantRepository->getCommit();
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function findByCanonical(string $canonical): array
    {
        try {
            return $this->productRepository->findByCanonical($canonical);
        } catch (\Exception $e){
            throw $e;
        }
    }
}