<?php

namespace App\Repository;

use App\Entity\Tutorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tutorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tutorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tutorial[]    findAll()
 * @method Tutorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutorialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tutorial::class);
    }

    /**
     * @return Query
     */
    public function findAllTutos():Query
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.datecreation', 'DESC')
            ->getQuery();
    }

    /**
     * @param int $nb
     * @param string $ob_param
     * @return Tutorial[]
     */
    public function findTutorials_OB_L(int $nb, string $ob_param):array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.' . $ob_param, 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }
}
