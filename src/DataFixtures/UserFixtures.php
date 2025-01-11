<?php

namespace App\DataFixtures;

use App\Factory\MedicineCategoryFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'batman@example.com',
            'firstname' => 'Bruce',
            'lastname' => 'Banner',
            'password' => 'test',
            'roles' => ['ROLE_ADMIN'],
            'category' => MedicineCategoryFactory::random(),
        ]);

        UserFactory::createOne([
            'email' => 'mickey@example.com',
            'firstname' => 'Mickey',
            'lastname' => 'Mouse',
            'password' => 'test',
            'roles' => ['ROLE_USER'],
            'category' => MedicineCategoryFactory::randomOrCreate(),
        ]);

        UserFactory::createMany(15, function () {
            return [
                'roles' => ['ROLE_USER'],
                'category' => MedicineCategoryFactory::randomOrCreate(),
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            MedicineCategoryFixtures::class,
        ];
    }
}
