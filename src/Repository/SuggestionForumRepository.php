<?php

namespace App\Repository;

use App\Entity\SuggestionForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SuggestionForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuggestionForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuggestionForum[]    findAll()
 * @method SuggestionForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestionForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SuggestionForum::class);
    }

    /**
     * @param $user
     * @return SuggestionForum[]
     */
    public function FindOwnSuggestionsForum($user):array
    {
        return $this->createQueryBuilder('sf')
            ->join('sf.idForum', 'id_forum')
            ->where('id_forum.idUser = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
