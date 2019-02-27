<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ProfileRepository
 * @package AppBundle\Entity\Repository
 */
class ProfileRepository extends ServiceEntityRepository
{

    private const ALIAS = 'profile';

    /**
     * ProfileRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getProfilesByUser(int $userId)
    {
        $query = $this->getProfilesByUserQueryBuilder($userId);
        return $query->getQuery()->execute();
    }

    /**
     * @param int $userId
     * @return QueryBuilder
     */
    public function getProfilesByUserQueryBuilder(int $userId): QueryBuilder
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->innerJoin(
                'profile.application',
                'application',
                Join::WITH,
                'application.user = :userId'
            )
            ->setParameter('userId', $userId);
    }

    /**
     * @param int $userId
     * @param int $month
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getProfilesCountByUser(int $userId, int $month = -1)
    {
        $qb = $this->getProfilesByUserQueryBuilder($userId);
        $qb
            ->select(
                $qb->expr()->count('profile.id')
            );

        if ($month > 0) {
            $yearMonth = date('Y') . '-' . $month;
            $firstDate = date('Y-m-d 00:00:00', strtotime('first day of ' . $yearMonth));
            $lastDate = date('Y-m-d 23:59:59', strtotime('last day of ' . $yearMonth));
            $qb
                ->andWhere('profile.created >= :firstDate')
                ->andWhere('profile.created <= :lastDate')
                ->setParameter('firstDate', $firstDate)
                ->setParameter('lastDate', $lastDate);
        }

        return (int)$qb
            ->getQuery()
            ->getSingleScalarResult();
    }
}
