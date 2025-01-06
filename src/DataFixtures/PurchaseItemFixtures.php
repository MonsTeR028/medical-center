<?php

namespace App\DataFixtures;

use App\Factory\BatchMedicineFactory;
use App\Factory\PurchaseFactory;
use App\Factory\PurchaseItemFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PurchaseItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $purchases = PurchaseFactory::all();

        foreach ($purchases as $purchase) {
            PurchaseItemFactory::createMany(rand(1, 5), function () use ($purchase) {
                return [
                    'idPurchase' => $purchase,
                    'idBatchMedicine' => BatchMedicineFactory::random(),
                ];
            }
            );
        }
    }

    public function getDependencies(): array
    {
        return [
            PurchaseFixtures::class,
            BatchMedicineFixtures::class,
        ];
    }
}
