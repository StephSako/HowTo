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
     * @param string $pseudo
     * @return User[]
     */
    public function findSearchedUsers(string $pseudo): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.lastname')
            ->addSelect('u.firstname')
            ->where('u.firstname LIKE :pseudo_firstname')
            ->orWhere('u.lastname LIKE :pseudo_lastname')
            ->setParameter('pseudo_firstname', '%'.$pseudo.'%')
            ->setParameter('pseudo_lastname', '%'.$pseudo.'%')
            ->getQuery()
            ->getResult();
    }
}
