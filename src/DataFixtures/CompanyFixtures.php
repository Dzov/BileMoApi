<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    const COMPANY_1 = 'company1';

    const COMPANY_2 = 'company2';

    const COMPANY_3 = 'company3';

    public function load(ObjectManager $manager)
    {
        $company1 = new Company();
        $company1->setName('Orange');
        $company1->setApiKey('azezhjh3462ZGZ');
        $company1->setApiPassword('test');
        $manager->persist($company1);

        $company2 = new Company();
        $company2->setName('Free');
        $company2->setApiKey('cvblng45443AFQ');
        $company2->setApiPassword('test');
        $manager->persist($company2);

        $company3 = new Company();
        $company3->setName('SFR');
        $company3->setApiKey('H34FSHSA3RF');
        $company3->setApiPassword('test');
        $manager->persist($company3);

        $manager->flush();

        $this->addReference(self::COMPANY_1, $company1);
        $this->addReference(self::COMPANY_2, $company2);
        $this->addReference(self::COMPANY_3, $company3);
    }
}
