<?php

namespace App\DataFixtures;

use App\Factory\MedicineCategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MedicineCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = file_get_contents(__DIR__ . '/data/data_medicines_fixtures.json');
        $medicines = json_decode($data, true);
        $alreadyDone = [];

        foreach ($medicines as $medicineData) {
            if (in_array($medicineData['category'], $alreadyDone)) {
                continue;
            }

            $alreadyDone[] = $medicineData['category'];
            MedicineCategoryFactory::createOne(['name' => $medicineData['category']]);
        }
    }
}
