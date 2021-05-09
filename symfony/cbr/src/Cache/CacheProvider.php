<?php

declare(strict_types=1);

namespace App\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

abstract class CacheProvider
{
    private AdapterInterface $cachePool;

    public function __construct(AdapterInterface $cachePool)
    {
        $this->cachePool = $cachePool;
    }

    public function save(string $key, $value): void
    {
        $cacheItem = $this->getCacheItem($key);
        $cacheItem->set($value);
        $this->cachePool->save($cacheItem);
    }

    public function get(string $key)
    {
        return $this->getCacheItem($key)->get();
    }

    private function getCacheItem($key): CacheItem
    {
        return $this->cachePool->getItem($key);
    }

    public function delete(string $key): void
    {
        $this->cachePool->delete($key);
    }

    public function isHit(string $key): bool
    {
        return $this->getCacheItem($key)->isHit();
    }

    public function clear(): void
    {
        $this->cachePool->clear();
    }
}
