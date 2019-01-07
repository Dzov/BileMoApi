<?php

namespace App\DataFixtures;

use App\Entity\CompanyCustomer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyCustomerFixtures extends Fixture implements DependentFixtureInterface
{
    const COMPANY_CUSTOMER_1 = 'customer1';

    const COMPANY_CUSTOMER_2 = 'customer2';

    const COMPANY_CUSTOMER_3 = 'customer3';

    const COMPANY_CUSTOMER_4 = 'customer4';

    const COMPANY_CUSTOMER_5 = 'customer5';

    public function load(ObjectManager $manager)
    {
        $customer1 = new CompanyCustomer();
        $customer1->setEmail('jackson@gmail.com');
        $customer1->setLastName('Cauba');
        $customer1->setFirstName('Jackson');
        $customer1->setCompany($this->getReference(CompanyFixtures::COMPANY_1));
        $manager->persist($customer1);

        $customer2 = new CompanyCustomer();
        $customer2->setEmail('clarence@gmail.com');
        $customer2->setLastName('Kern');
        $customer2->setFirstName('Clarence');
        $customer2->setCompany($this->getReference(CompanyFixtures::COMPANY_1));
        $manager->persist($customer2);

        $customer3 = new CompanyCustomer();
        $customer3->setEmail('rodrigue@gmail.com');
        $customer3->setLastName('Domel');
        $customer3->setFirstName('Rodrigue');
        $customer3->setCompany($this->getReference(CompanyFixtures::COMPANY_2));
        $manager->persist($customer3);

        $customer4 = new CompanyCustomer();
        $customer4->setEmail('clem@gmail.com');
        $customer4->setLastName('Stern');
        $customer4->setFirstName('Clemence');
        $customer4->setCompany($this->getReference(CompanyFixtures::COMPANY_3));
        $manager->persist($customer4);

        $customer5 = new CompanyCustomer();
        $customer5->setEmail('mathilda@gmail.com');
        $customer5->setLastName('Jacks');
        $customer5->setFirstName('Mathilda');
        $customer5->setCompany($this->getReference(CompanyFixtures::COMPANY_3));
        $manager->persist($customer5);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
