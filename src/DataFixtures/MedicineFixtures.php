<?php

namespace App\DataFixtures;

use App\Factory\MedicineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicineFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = file_get_contents(__DIR__.'/data/data_medicines_fixtures.json');
        $medicines = json_decode($data, true);

        foreach ($medicines as $medicineData) {
            MedicineFactory::createOne($medicineData);
        }
    }
}
