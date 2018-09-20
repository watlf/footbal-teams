<?php

namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var League $league */
        $league = $this->getReference(LeagueFixtures::LEAGUE_TEAM_REFERENCE);

        $teams = ['Arsenal', 'Aston Villa', 'Barnsley', 'Birmingham City', 'Blackburn Rovers'];

        foreach ($teams as $teamName) {
            $team = new Team();

            $team->setName($teamName);

            $league->addTeam($team);
        }

        $manager->persist($league);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            LeagueFixtures::class,
        ];
    }
}
