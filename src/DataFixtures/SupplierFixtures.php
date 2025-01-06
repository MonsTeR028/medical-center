<?php

namespace App\DataFixtures;

use App\Factory\SupplierFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SupplierFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SupplierFactory::createMany(10);
    }
}
