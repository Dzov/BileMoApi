<?php

namespace App\Manager\Product;

use App\Entity\MobilePhone;
use App\Manager\AbstractManager;
use App\Repository\MobilePhoneRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ProductManager extends AbstractManager
{
    /**
     * @var MobilePhoneRepository
     */
    private $repository;

    public function __construct(MobilePhoneRepository $repository, AdapterInterface $cache)
    {
        parent::__construct($cache);
        $this->repository = $repository;
    }

    /**
     * @return MobilePhone[]
     */
    public function listMobilePhones(): array
    {
        $cacheItem = $this->cacheItem('products.list');

        if (!$cacheItem->isHit()) {
            $phones = $this->repository->findAll();

            $this->setCacheItem($cacheItem, $phones);
        }

        return $cacheItem->get();
    }

    public function showMobilePhone(int $phoneId): MobilePhone
    {
        $cacheItem = $this->cacheItem('products.' . $phoneId);

        if (!$cacheItem->isHit()) {
            $phone = $this->repository->find($phoneId);

            $this->setCacheItem($cacheItem, $phone);
        }

        return $cacheItem->get();
    }
}
