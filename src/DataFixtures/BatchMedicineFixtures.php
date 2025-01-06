<?php

namespace App\DataFixtures;

use App\Factory\BatchMedicineFactory;
use App\Factory\MedicineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BatchMedicineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        BatchMedicineFactory::createMany(50, function () {
            return ['idMed' => MedicineFactory::random()];
        }
        );
    }

    public function getDependencies(): array
    {
        return [
            MedicineFixtures::class,
        ];
    }
}
