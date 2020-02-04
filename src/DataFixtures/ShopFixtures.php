<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ShopFixtures extends Fixture implements DependentFixtureInterface
{
    private const SHOPS = [
        ['Heroes Shop', 'bob-user', 'bob-shop'],
        ['Evil Shop',  'kevin-user', 'kevin-shop'],
        ['KarliTool Shop',  'karl-user', 'karl-shop'],
    ];

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        foreach (self::SHOPS as $dataShop) {
            $shop = new Shop();
            $shop->setUser($this->getReference($dataShop[1]));
            $shop->setTitle($dataShop[0]);
            $manager->persist($shop);
        }
        $this->addReference($dataShop[2], $shop);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
