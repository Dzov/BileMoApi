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

    public function __construct(AdapterInterface $cache, MobilePhoneRepository $repository)
    {
        parent::__construct($cache);
        $this->repository = $repository;
    }

    /**
     * @return MobilePhone[]
     */
    public function listMobilePhones(): array
    {
        $cacheItem = $this->getCacheItem('products.list');

        if (!$cacheItem->isHit()) {
            $phones = $this->repository->findAll();

            $this->setItem($cacheItem, $phones);
        }

        return $cacheItem->get();
    }

    public function showMobilePhone(int $phoneId): MobilePhone
    {
//        return $this->getItem('products.' . $phoneId, function () use ($repository))
        {}


        $cacheItem = $this->getCacheItem();

        if (!$cacheItem->isHit()) {
            $phone = $this->repository->find($phoneId);

            $this->setItem($cacheItem, $phone);
        }

        return $cacheItem->get();
    }
}
