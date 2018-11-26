<?php

namespace App\DataFixtures;

use App\Entity\CompanyEmployee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyEmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    const EMPLOYEE_1 = 'employee1';

    const EMPLOYEE_2 = 'employee2';

    const EMPLOYEE_3 = 'employee3';

    const EMPLOYEE_4 = 'employee4';

    const EMPLOYEE_5 = 'employee5';

    public function load(ObjectManager $manager)
    {
        $employee1 = new CompanyEmployee();
        $employee1->setCompany($this->getReference(CompanyFixtures::COMPANY_1));
        $employee1->setPassword(password_hash('john', PASSWORD_BCRYPT));
        $employee1->setEmail('john.simmons@gmail.com');
        $manager->persist($employee1);

        $employee2 = new CompanyEmployee();
        $employee2->setCompany($this->getReference(CompanyFixtures::COMPANY_1));
        $employee2->setPassword(password_hash('sam', PASSWORD_BCRYPT));
        $employee2->setEmail('sam.sander@gmail.com');
        $manager->persist($employee2);

        $employee3 = new CompanyEmployee();
        $employee3->setCompany($this->getReference(CompanyFixtures::COMPANY_2));
        $employee3->setPassword(password_hash('alex', PASSWORD_BCRYPT));
        $employee3->setEmail('alex.shaw@gmail.com');
        $manager->persist($employee3);

        $employee4 = new CompanyEmployee();
        $employee4->setCompany($this->getReference(CompanyFixtures::COMPANY_3));
        $employee4->setPassword(password_hash('ahmed', PASSWORD_BCRYPT));
        $employee4->setEmail('ahmed.tiha@gmail.com');
        $manager->persist($employee4);

        $employee5 = new CompanyEmployee();
        $employee5->setCompany($this->getReference(CompanyFixtures::COMPANY_3));
        $employee5->setPassword(password_hash('kimmy', PASSWORD_BCRYPT));
        $employee5->setEmail('kimmy.gale@gmail.com');
        $manager->persist($employee5);

        $manager->flush();

        $this->addReference(self::EMPLOYEE_1, $employee1);
        $this->addReference(self::EMPLOYEE_2, $employee2);
        $this->addReference(self::EMPLOYEE_3, $employee3);
        $this->addReference(self::EMPLOYEE_4, $employee4);
        $this->addReference(self::EMPLOYEE_5, $employee5);
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
