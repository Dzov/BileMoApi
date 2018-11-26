<?php

namespace App\DataFixtures;

use App\Entity\MobilePhone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MobilePhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product1 = new MobilePhone();
        $product1->setName('Galaxy S7');
        $product1->setBrand('Samsung');
        $product1->setPrice(319);
        $product1->setStorage('32 Go');
        $product1->setScreenSize('5"');
        $product1->setOs('Android');
        $manager->persist($product1);

        $product2 = new MobilePhone();
        $product2->setName('iPhone X');
        $product2->setBrand('Apple');
        $product2->setPrice(899);
        $product2->setStorage('64 Go');
        $product2->setScreenSize('5,8"');
        $product2->setOs('iOS 11');
        $manager->persist($product2);

        $product3 = new MobilePhone();
        $product3->setName('Honor 8X');
        $product3->setBrand('Honor');
        $product3->setPrice(249);
        $product3->setStorage('64 Go');
        $product3->setScreenSize('6,5"');
        $product3->setOs('Android');
        $manager->persist($product3);

        $product4 = new MobilePhone();
        $product4->setName('Huawei Y6 2018');
        $product4->setBrand('Huawei');
        $product4->setPrice(119);
        $product4->setStorage('16 Go');
        $product4->setScreenSize('5,7"');
        $product4->setOs('Android');
        $manager->persist($product4);

        $manager->flush();
    }
}
