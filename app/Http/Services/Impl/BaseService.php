<?php
namespace App\Http\Services\Impl;

use App\Exceptions\ModelNotFoundException;
use App\Http\Helpers\Cache;
use App\Http\Services\Interfaces\BaseServiceInterface;
use App\Traits\HasHook;
use App\Traits\HasCache;
use App\Traits\Loggable;

abstract class BaseService implements BaseServiceInterface
{
    use HasHook, HasCache, Loggable;
    protected $baseRepository;
    protected $baseModel;
    protected array $payload = [];
    protected array $payloadRelation = [];
    protected array $data = [];
    protected mixed $result;

    protected array $fieldSearch = ['name'];
    protected array $simpleFilter = ['publish'];
    protected array $complexFilter = ['id'];
    protected array $dateFilter = ['created_at', 'updated_at'];
    protected array $with = [];

    protected const PER_PAGE = 20;

    public function __construct($baseRepository, $baseModel)
    {
        $this->baseRepository = $baseRepository;
        $this->baseModel = $baseModel;
    }

    abstract public function prepareModelData(): self;

    public function specification($request): array
    {
        return [
            'type' => $request['type'] ?? '',
            'perpage' => $request['perpage'] ?? self::PER_PAGE,
            'sort' => !empty($request['sort']) ? explode(',', $request['sort']) : ['id', 'desc'],
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

    protected function buildFilter($request, array $filters): array
    {
        $conditions = [];
        foreach ($filters as $filter) {
            $fieldKey = str_contains($filter, '.') ? explode('.', $filter)[1] : $filter;

            if (isset($request[$fieldKey])) {
                $conditions[$filter] = $request[$fieldKey];
            }
        }
        return $conditions;
    }

    public function paginate($request)
    {
        try {
            $startTime = microtime(true);

            $cacheKey = $this->getPaginationCacheKey($request);
            $lockKey = "lock:" . $cacheKey;

            $lockAcquired = Cache::set($lockKey, 1, 10);

            if (!$lockAcquired) {
                $waitTime = 0;
                while ($waitTime < 5) {
                    usleep(500000);
                    if (!Cache::exists($lockKey)) {
                        $lockAcquired = Cache::set($lockKey, 1, 10);
                        if ($lockAcquired) break;
                    }
                    $waitTime += 0.5;
                }
            }

            if (!$lockAcquired) {
                $specifications = $this->specification($request);
                $result = $this->baseRepository->pagination($specifications);
            }

            if (!$result = Cache::getGroup($cacheKey)) {
                $specifications = $this->specification($request);
                $result = $this->baseRepository->pagination($specifications);
                Cache::setGroup($cacheKey, $result, $this->cacheTTL);
            }
            Cache::del($lockKey);

            $endTime = microtime(true);
            $duration = $endTime - $startTime;

//            $this->logTimeQuery([
//                'module' => 'Paginate - ' . static::class,
//                'file' => __FILE__,
//                'line' => __LINE__,
//                'time_sec' => round($duration, 4)
//            ]);

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function all()
    {
        try {
            $request = $_GET;
            $cacheKey = $this->getPaginationCacheKey($request);
            $lockKey = "lock:" . $cacheKey;

            $lockAcquired = Cache::set($lockKey, 1, 10);

            if (!$lockAcquired) {
                $waitTime = 0;
                while ($waitTime < 5) {
                    usleep(500000);
                    if (!Cache::exists($lockKey)) {
                        $lockAcquired = Cache::set($lockKey, 1, 10);
                        if ($lockAcquired) break;
                    }
                    $waitTime += 0.5;
                }
            }

            if (!$lockAcquired) {
                $result = $this->baseRepository->all();
            }

            if (!$result = Cache::getGroup($cacheKey)) {
                $result = $this->baseRepository->all();
                Cache::setGroup($cacheKey, $result, $this->cacheTTL);
            }
            Cache::del($lockKey);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function show(int $id = 0)
    {
        try {
            $lockKey  = "lock:" . $this->getCacheKeyById($id);
            $lockAcquired = Cache::set($lockKey, 1, 10);
            if (!$lockAcquired) {
                $waitTime = 0;
                while ($waitTime < 5) {
                    usleep(500000);
                    if (!Cache::exists($lockKey)) {
                        $lockAcquired = Cache::set($lockKey, 1, 10);
                        if ($lockAcquired) break;
                    }
                    $waitTime += 0.5;
                }
            }
            if (!$lockAcquired) {
                $model = $this->baseRepository->findById($id);
                if (!$model) {
                    throw new ModelNotFoundException("Không tìm thấy bản ghi phù hợp");
                }
                return $model;
            }
            if (!$model = Cache::get($this->getCacheKeyById($id))) {
                $model = $this->baseRepository->findById($id);
                if (!$model) {
                    throw new ModelNotFoundException("Không tìm thấy bản ghi phù hợp");
                }
                Cache::set($this->getCacheKeyById($id), $model, $this->cacheTTL);
            }
            Cache::del($lockKey);
            return $model;
        } catch (\Exception $e) {
            Cache::del($lockKey);
            throw $e;
        }
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
                ->afterSave($id)
                ->getResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete(int $id = null): bool
    {
        try {
            return $this->beginTransaction()
                ->beforeDelete($id)
                ->deleteModel()
                ->commit()
                ->afterDelete($id)
                ->getResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}