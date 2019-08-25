<?php

namespace App\Repository;

use App\Entity\Forum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Forum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forum[]    findAll()
 * @method Forum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Forum::class);
    }

    /**
     * @return Query
     */
    public function findAllForums():Query
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.datecreation', 'DESC')
            ->getQuery();
    }

    /**
     * @param int $nb
     * @param string $ob_param
     * @return Forum[]
     */
    public function findForums_OB_L(int $nb, string $ob_param):array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.' . $ob_param, 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }
}
