<?php

namespace App\DataFixtures;

use App\Factory\OrderFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        OrderFactory::createMany(50, function () {
            return ['idUser' => UserFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
