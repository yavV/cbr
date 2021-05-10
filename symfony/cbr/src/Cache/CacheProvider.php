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

    /**
     * @param string $key
     * @param $value
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function save(string $key, $value): void
    {
        $cacheItem = $this->getCacheItem($key);
        $cacheItem->set($value);
        $this->cachePool->save($cacheItem);
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function get(string $key)
    {
        return $this->getCacheItem($key)->get();
    }

    /**
     * @param string $key
     * @return CacheItem
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function getCacheItem(string $key): CacheItem
    {
        return $this->cachePool->getItem($key);
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function isHit(string $key): bool
    {
        return $this->getCacheItem($key)->isHit();
    }

    public function clear(): void
    {
        $this->cachePool->clear();
    }
}
