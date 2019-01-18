<?php

namespace App\Manager\Product;

use App\Entity\MobilePhone;
use App\Service\Product\ProductCacheService;

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
        return $this->cacheService->getMobilePhones();
    }

    public function showMobilePhone(int $phoneId): MobilePhone
    {
        return $this->cacheService->getMobilePhone($phoneId);
    }
}
