<?php
namespace App\Http\Services\Impl\Post;

use App\Http\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Post\PostCatalogueServiceInterface;
use App\Models\PostCatalogue;
use App\Classes\Nested;
use App\Traits\HasHook;
use App\Traits\Str;

class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    use HasHook, Str;
    protected PostCatalogueRepository $postCatalogueRepository;
    protected PostCatalogue $postCatalogueModel;
    protected Nested $nested;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['admins'];

    protected const CACHE_KEY_PREFIX = 'post_catalogues';
    private const NESTED_SET_TABLE = 'post_catalogues';

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository
    )
    {
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->postCatalogueModel = new PostCatalogue();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($postCatalogueRepository, $this->postCatalogueModel);
    }

    public function specification($request): array
    {
        return [
            'type' => $request['type'] ?? '',
            'perpage' => $request['perpage'] ?? self::PER_PAGE,
            'sort' => !empty($request['sort']) ? explode(',', $request['sort']) : ['lft', 'asc'],
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
        $payload['admin_id'] = $_SESSION['admin']['id'];
        $this->payload = $payload;
    }


    protected function nestedSet(): void
    {
        $this->nested = new Nested([
            'table' => self::NESTED_SET_TABLE
        ]);
        $this->callNested($this->nested);
    }

    protected function afterSave(?int $id = null):self {
        $this->nestedSet();
        return $this->clearSingleRecordCache()->cacheSingleRecord()->clearCollectionRecordCache();
    }

    protected function afterDelete(int $id = null): self{
        $this->nestedSet();
        return $this->clearSingleRecordCache($id)->clearCollectionRecordCache();
    }
}