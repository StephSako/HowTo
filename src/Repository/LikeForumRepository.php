<?php

namespace App\Repository;

use App\Entity\Forum;
use App\Entity\LikeForum;
use App\Entity\Tutorial;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method LikeForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeForum[]    findAll()
 * @method LikeForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LikeForum::class);
    }

    /**
     * @param Forum $id
     * @return int
     * @throws NonUniqueResultException
     */
    public function getNbLikes(Forum $id):int
    {
        return $this->createQueryBuilder('lf')
            ->select('COUNT(IDENTITY(lf.idUser)) AS count')
            ->where('lf.idForum = :id')
            ->setParameter('id', $id)
            ->groupBy('lf.idForum')
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR) ?? 0;
    }

    /**
     * @param User $idUser
     * @param Forum $id
     * @return LikeForum
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findForumLiked(User $idUser, Forum $id):LikeForum
    {
        return $this->createQueryBuilder('lf')
            ->where('lf.idUser = :idUser')
            ->andWhere('lf.idForum = :id')
            ->setParameter('idUser', $idUser)
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }
}
