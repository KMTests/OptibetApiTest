<?php

namespace ApiBundle\DataFixtures\ORM;

use ApiBundle\Entity\Tournament;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTournamentData
 * @package ApiBundle\DataFixtures\ORM
 */
class LoadTournamentData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $tournament = new Tournament();
        $manager->persist($tournament);
        $manager->flush();
    }
}