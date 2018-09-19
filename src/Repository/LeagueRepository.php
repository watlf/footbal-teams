<?php

namespace App\Repository;

use App\Entity\League;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method League|null find($id, $lockMode = null, $lockVersion = null)
 * @method League|null findOneBy(array $criteria, array $orderBy = null)
 * @method League[]    findAll()
 * @method League[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeagueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, League::class);
    }

    /**
     * Get a list of football teams in a single league
     * @param int $leagueId
     */
    public function findTeams(int $leagueId)
    {

    }

    /**
     * Delete a football league
     *
     * @param int $leagueId
     */
    public function deleteLeague(int $leagueId)
    {

    }
}
