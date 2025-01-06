<?php

namespace App\DataFixtures;

use App\Factory\MedicineCategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicineCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MedicineCategoryFactory::createMany(5);
    }
}
