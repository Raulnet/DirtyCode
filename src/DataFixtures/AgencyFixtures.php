<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AgencyFixtures extends Fixture implements DependentFixtureInterface
{
    private const AGENCIES = [
        ['Heroes Agency', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et', 'bob-user', 'bob-agency'],
        ['Evil Company', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam', 'karl-user', 'kevin-agency'],
    ];

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        foreach (self::AGENCIES as $dataAgency) {
            $agency = new Agency();
            $agency->setTitle($dataAgency[0]);
            $agency->setDescription($dataAgency[1]);
            $manager->persist($agency);
            if (\array_key_exists(2, $dataAgency)) {
                $agency->setUser($this->getReference($dataAgency[2]));
            }
            $this->addReference($dataAgency[3], $agency);
        }

        $manager->flush();
    }
}
