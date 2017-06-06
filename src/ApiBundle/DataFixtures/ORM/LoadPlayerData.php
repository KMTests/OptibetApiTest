<?php

namespace ApiBundle\DataFixtures\ORM;

use ApiBundle\Entity\Player;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadPlayerData
 * @package ApiBundle\DataFixtures\ORM
 */
class LoadPlayerData implements FixtureInterface {

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        for($i = 0; $i < 5; $i++) {
            $player = new Player();
            $player->setBonusPoints(0);
            $manager->persist($player);
        }
        $manager->flush();
    }

}