<?php

namespace App\Manager;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractManager
{
    /**
     * @var FilesystemAdapter
     */
    protected $cache;

    protected function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    protected function invalidateCache(string $key): void
    {
        $this->cache->deleteItem($key);
    }

    protected function getCacheItem(string $key): CacheItem
    {
        return $this->cache->getItem($key);
    }

    protected function setItem(CacheItem $cacheItem, $data)
    {
        $cacheItem->set($data);
        $this->cache->save($cacheItem);
    }
}
