<?php

namespace App\DataFixtures;

use App\Factory\PurchaseFactory;
use App\Factory\SupplierFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PurchaseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PurchaseFactory::createMany(50, function () {
            return ['idSupp' => SupplierFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [
            SupplierFixtures::class,
        ];
    }
}
