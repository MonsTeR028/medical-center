<?php

namespace App\DataFixtures;

use App\Factory\MedicineCategoryFactory;
use App\Factory\MedicineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MedicineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = file_get_contents(__DIR__.'/data/data_medicines_fixtures.json');
        $medicines = json_decode($data, true);

        foreach ($medicines as $medicineData) {
            $medicineData['category'] = MedicineCategoryFactory::findBy(['name' => $medicineData['category']])[0];
            MedicineFactory::createOne($medicineData);
        }
    }

    public function getDependencies(): array
    {
        return [
            MedicineCategoryFixtures::class,
        ];
    }
}
