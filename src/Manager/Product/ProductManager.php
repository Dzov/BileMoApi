<?php

namespace App\Manager\Product;

use App\Entity\MobilePhone;
use App\Service\Product\ProductCacheService;
use Symfony\Component\Cache\CacheItem;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ProductManager
{
    /**
     * @var ProductCacheService
     */
    private $cacheService;

    public function __construct(ProductCacheService $service)
    {
        $this->cacheService = $service;
    }

    /**
     * @return MobilePhone[]
     */
    public function listMobilePhones(): array
    {
        return $this->cacheService->getCacheList();
    }

    public function showMobilePhone(int $phoneId): CacheItem
    {
        return $this->cacheService->getCacheItem([ProductCacheService::PRODUCT_ID => $phoneId]);
    }
}
