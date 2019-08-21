<?php

namespace App\Repository;

use App\Entity\Tutorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tutorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tutorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tutorial[]    findAll()
 * @method Tutorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutorialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, ObjectManager $em)
    {
        parent::__construct($registry, Tutorial::class);
        $this->em = $em;
    }

    private $em;

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

    /**
     * @param string $ob_param
     * @param int $id_cat
     * @return Tutorial[]
     */
    public function categoryList(string $ob_param, int $id_cat):array
    {
        return $this->createQueryBuilder('t')
            ->where('t.idCategory = :id_cat')
            ->orderBy('t.' . $ob_param, 'DESC')
            ->setParameter('id_cat', $id_cat)
            ->getQuery()
            ->getResult();
    }
}
