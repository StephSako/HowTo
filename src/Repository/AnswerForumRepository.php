<?php

namespace App\Repository;

use App\Entity\AnswerForum;
use App\Entity\Forum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnswerForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerForum[]    findAll()
 * @method AnswerForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnswerForum::class);
    }

    /**
     * @param Forum $id
     * @return AnswerForum[]
     */
    public function findAnswerForums(Forum $id):array
    {
        return $this->createQueryBuilder('af')
            ->where('af.idForum = :id')
            ->setParameter('id', $id)
            ->orderBy('af.dateresponse', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
