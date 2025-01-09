<?php

namespace App\DataFixtures;

use App\Factory\AdresseFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use function Zenstruck\Foundry\faker;

class AdresseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = UserFactory::all();

        AdresseFactory::createMany(30, function () use ($users) {
            return ['user' => faker()->randomElement($users)];
        });

        AdresseFactory::createOne(function () {
            return ['user' => UserFactory::find(['id' => 1])];
        });

        AdresseFactory::createOne(function () {
            return ['user' => UserFactory::find(['id' => 2])];
        });
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
