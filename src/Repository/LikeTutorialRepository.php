<?php

namespace App\Repository;

use App\Entity\LikeTutorial;
use App\Entity\Tutorial;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LikeTutorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeTutorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeTutorial[]    findAll()
 * @method LikeTutorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeTutorialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LikeTutorial::class);
    }

    /**
     * @param Tutorial $id
     * @return int
     * @throws NonUniqueResultException
     */
    public function getNbLikes(Tutorial $id):int
    {
        return $this->createQueryBuilder('lt')
                ->select('COUNT(IDENTITY(lt.idUser)) AS count')
                ->where('lt.idTutorial = :id')
                ->setParameter('id', $id)
                ->groupBy('lt.idTutorial')
                ->getQuery()
                ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR) ?? 0;
    }

    /**
     * @param User $idUser
     * @param Tutorial $id
     * @return LikeTutorial
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findTutoLiked(User $idUser, Tutorial $id):LikeTutorial
    {
        return $this->createQueryBuilder('lt')
            ->where('lt.idUser = :idUser')
            ->andWhere('lt.idTutorial = :id')
            ->setParameter('idUser', $idUser)
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }
}
