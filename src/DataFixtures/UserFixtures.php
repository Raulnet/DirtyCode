<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private const USERS = [
        ['admin', ['ROLE_USER', 'ROLE_ADMIN']],
        ['karl', ['ROLE_USER', 'ROLE_CUSTOM'], 'karl-user'],
        ['bob', ['ROLE_USER', 'ROLE_CUSTOM'], 'bob-user'],
        ['kevin', ['ROLE_USER', 'ROLE_CUSTOM'], 'kevin-user'],
        ['stuart', ['ROLE_USER', 'ROLE_CUSTOM']],
        ['user1', ['ROLE_USER']],
        ['user2', ['ROLE_USER']],
        ['user3', ['ROLE_USER']],
        ['user4', ['ROLE_USER']],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $dataUser) {
            $user = new User();
            $user->setUsername($dataUser[0]);
            $user->setPassword($dataUser[0]);
            $user->setRoles($dataUser[1]);
            $manager->persist($user);
            if (\array_key_exists(2, $dataUser)) {
                $this->addReference($dataUser[2], $user);
            }
        }

        $manager->flush();
    }
}
