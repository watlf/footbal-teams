<?php

namespace App\DataFixtures;

use App\Entity\League;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LeagueFixtures extends Fixture
{
    const LEAGUE_TEAM_REFERENCE = 'league_team';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $league = new League();

        $league->setName('UK Premier League');

        $manager->persist($league);
        $manager->flush();

        $this->addReference(self::LEAGUE_TEAM_REFERENCE, $league);
    }
}
