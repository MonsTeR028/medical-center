<?php

namespace App\DataFixtures;

use App\Factory\BatchMedicineFactory;
use App\Factory\OrderFactory;
use App\Factory\OrderItemFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $orders = OrderFactory::all();

        foreach ($orders as $order) {
            OrderItemFactory::createMany(rand(1, 5), function () use ($order) {
                return [
                    'idOrder' => $order,
                    'idBatchMedicine' => BatchMedicineFactory::random(),
                ];
            });
        }
    }

    public function getDependencies(): array
    {
        return [
            OrderFixtures::class,
            BatchMedicineFixtures::class,
        ];
    }
}
