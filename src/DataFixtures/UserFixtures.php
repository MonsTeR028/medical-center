<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'batman@example.com',
            'firstname' => 'Bruce',
            'lastname' => 'Banner',
            'password' => 'test',
            'roles' => ['ROLE_ADMIN'], ]);
        UserFactory::createOne([
            'email' => 'mickey@example.com',
            'firstname' => 'Mickey',
            'lastname' => 'Mouse',
            'password' => 'test',
            'roles' => ['ROLE_USER'], ]);
        $manager->flush();
    }
}
