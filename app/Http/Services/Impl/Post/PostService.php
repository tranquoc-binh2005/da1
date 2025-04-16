<?php
namespace App\Http\Services\Impl\Post;

use App\Http\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Http\Services\Impl\BaseService;
use App\Http\Services\Interfaces\Post\PostServiceInterface;
use App\Models\Post;
use App\Classes\Nested;
use App\Traits\HasHook;
use App\Traits\Str;

class PostService extends BaseService implements PostServiceInterface
{
    use HasHook, Str;
    protected PostRepository $postRepository;
    protected Post $postModel;
    protected Nested $nested;
    protected string $cacheKeyPrefix = '';
    protected array $fieldSearch = ['tb1.name'];
    protected array $simpleFilter = ['tb1.publish', 'tb1.post_catalogue_id'];
    protected array $complexFilter = ['tb1.id'];
    protected array $dateFilter = ['tb1.created_at', 'tb1.updated_at'];
    protected array $with = ['post_catalogues'];

    protected const CACHE_KEY_PREFIX = 'posts';

    public function __construct(
        PostRepository $postRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->postModel = new Post();
        $this->cacheKeyPrefix = self::CACHE_KEY_PREFIX;
        parent::__construct($postRepository, $this->postModel);
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
        $payload['canonical'] = $this->convertStringToSlug($payload['canonical']);
        $payload['admin_id'] = $_SESSION['admin']['id'];
        $this->payload = $payload;
    }

    public function findByCanonical(string $canonical): array
    {
        try {
            return $this->postRepository->findByCanonical($canonical);
        } catch (\Exception $e){
            throw $e;
        }
    }
}