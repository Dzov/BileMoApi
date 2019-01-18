<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractCacheService
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    protected function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    abstract protected function getItemKey(array $parameters = []): ?string;

    abstract protected function getListKey(): string;

    abstract protected function getItem(array $parameters = []);

    abstract protected function getList(array $parameters = []): array;

    abstract protected function removeItem(array $parameters = []);

    protected function getKeys(array $parameters = []): array
    {
        return [$this->getItemKey($parameters), $this->getListKey()];
    }

    protected function getCacheItem(array $parameters = [])
    {
        $cacheItem = $this->cache->getItem($this->getItemKey($parameters));

        if (!$cacheItem->isHit()) {
            $item = $this->getItem($parameters);

            $cacheItem->set($item);
            $this->cache->save($cacheItem);
        }

        return $cacheItem->get();
    }

    /**
     * @return CacheItem[]
     */
    protected function getCacheList(array $parameters = []): array
    {
        $cacheItem = $this->cache->getItem($this->getListKey());

        if (!$cacheItem->isHit()) {
            $list = $this->getList($parameters);

            $cacheItem->set($list);
            $this->cache->save($cacheItem);
        }

        return $cacheItem->get();
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function removeCacheItem(array $parameters = [])
    {
        $this->clearCache($parameters);

        $this->removeItem($parameters);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function clearCache(array $parameters = []): void
    {
        foreach ($this->getKeys($parameters) as $key) {
            $this->cache->deleteItem($key);
        }
    }
}
