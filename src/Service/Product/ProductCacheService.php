<?php

namespace App\Service\Product;

use App\Entity\MobilePhone;
use App\Repository\MobilePhoneRepository;
use App\Service\AbstractCacheService;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ProductCacheService extends AbstractCacheService
{
    const PRODUCT_ID    = 'productId';

    const PRODUCTS_LIST = 'products.list';

    /**
     * @var MobilePhoneRepository
     */
    private $repository;

    public function __construct(MobilePhoneRepository $repository, AdapterInterface $cache)
    {
        parent::__construct($cache);
        $this->repository = $repository;
    }

    public function getMobilePhone(int $productId): MobilePhone
    {
        return $this->getCacheItem([self::PRODUCT_ID => $productId]);
    }

    /**
     * @return MobilePhone[]
     */
    public function getMobilePhones(): array
    {
        return $this->getCacheList();
    }

    protected function getItemKey(array $parameters = []): ?string
    {
        if (isset($parameters[self::PRODUCT_ID])) {
            return 'products.' . $parameters[self::PRODUCT_ID];
        }
    }

    protected function getListKey(): string
    {
        return self::PRODUCTS_LIST;
    }

    protected function getItem(array $parameters = []): MobilePhone
    {
        try {
            $product = $this->repository->findById($parameters[self::PRODUCT_ID]);

            return $product;
        } catch (NoResultException $e) {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @return MobilePhone[]
     */
    protected function getList(array $parameters = []): array
    {
        return $this->repository->findAll();
    }

    protected function removeItem(array $parameters = []): void
    {
    }
}
