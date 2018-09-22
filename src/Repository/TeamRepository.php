<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * @param int $leagueId
     * @return Team[]
     */
    public function findTeamsByLeague(int $leagueId): array
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.league', 'l')
            ->addSelect('l')
            ->andWhere('t.league = :id')
            ->setParameter('id', $leagueId)
            ->getQuery()
            ->getArrayResult();
    }
}
