<?php

namespace App\Repository;

use App\Entity\SuggestionTutorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SuggestionTutorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuggestionTutorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuggestionTutorial[]    findAll()
 * @method SuggestionTutorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuggestionTutorialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SuggestionTutorial::class);
    }

    /**
     * @param $user
     * @return SuggestionTutorial[]
     */
    public function FindOwnSuggestionsTutorial($user):array
    {
        return $this->createQueryBuilder('st')
            ->join('st.idTutorial', 'id_tutorial')
            ->where('id_tutorial.idUser = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
