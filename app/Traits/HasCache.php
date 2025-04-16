<?php
namespace App\Traits;

use App\Http\Helpers\Cache;
trait HasCache
{
    protected string $cacheKeyPrefix = '';
    protected int $cacheTTL = 3600;


    protected function getRandomTTL(): int
    {
        return rand(3600, 4000);
    }

    protected function setTTL(?int $ttl = null): self
    {
        $this->cacheTTL = $ttl ?? $this->getRandomTTL();
        return $this;
    }

    protected function cacheSingleRecord(): self
    {
        $cacheKey = $this->getSingleRecordCacheKey();
        Cache::set($cacheKey, $this->result, $this->cacheTTL);
        return $this;
    }

    protected function getSingleRecordCacheKey(): string
    {
        $id = $this->result ? $this->result : $this->getIdByRoute();
        return "{$this->cacheKeyPrefix}:single:{$id}";
    }

    private function getIdByRoute(): int
    {
        $paramName = rtrim($this->cacheKeyPrefix, ':');
        return $_GET[$paramName] ?? 0;
    }

    protected function clearSingleRecordCache(int $id = null): self
    {
        $cacheKey = $this->getCacheKeyById($id);
        Cache::del($cacheKey);
        return $this;
    }


    protected function getPaginationCacheKey(array $params = []): string
    {
        krsort($params);
        $hash = md5(serialize($params));
        return $this->cacheKeyPrefix . ':collection:' . $hash;
    }

    protected function getCacheKeyById(int $id = null): string
    {
        return "{$this->cacheKeyPrefix}:single:{$id}";
    }

    protected function clearCollectionRecordCache(): self
    {
        $request = $_GET;
        $cacheKey = $this->getPaginationCacheKey($request);
        Cache::del($cacheKey);
        return $this;
    }
}

