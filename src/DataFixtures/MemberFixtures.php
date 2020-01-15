<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    private const MEMBERS = [
        ['Aatrox', 'aatrox@dirty.com', 'Harty Rocks', null, null],
        ['Diana', 'diana@dirty.com', 'Diane Ha', null, null],
        ['Draven', 'draven@dirty.com', 'Edouard Haven', '915-685-279', null],
        ['fizz', 'fizz@dirty.com', 'philip zipp', '915-600-025', 'https://euw.leagueoflegends.com/fr/'],
        ['Graves', 'graves@dirty.com', 'Gerard Vives', null, 'https://euw.leagueoflegends.com/fr/'],
        ['Hecarim', 'hecarim@dirty.com', 'Eric Mire', null, 'https://euw.leagueoflegends.com/fr/'],
        ['Irelia', 'irelia@dirty.com', 'Iren Lianne', '555-245-127', null],
        ['Jax', 'jax@dirty.com', 'Jacques Sec', '555-043-954', null],
        ['Kennen', 'kennen@dirty.com', 'Ken Hen', null, null],
        ['Morgana', 'morgana@dirty.com', 'Morgane anna', '555-689-147', null],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::MEMBERS as $dataMember) {
            $member = new Member();
            $member->setUsername($dataMember[0])
                ->setEmail($dataMember[1])
                ->setName($dataMember[2])
                ->setPhone($dataMember[3])
                ->setWebsite($dataMember[4]);

            $member->setAgency($this->getReference('bob-agency'));

            $manager->persist($member);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AgencyFixtures::class,
        ];
    }
}
