<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }


    /**
     * @param string $username
     * @return mixed|null|UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('user')
            ->where('user.email = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $token
     * @return User|null
     */
    public function getUserByConfirmationToken(string $token): ?User
    {
        if (strlen($token) == 0) {
            return null;
        }
        return $this->findOneBy(['confirmationToken' => $token]);
    }
}
