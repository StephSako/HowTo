<?php

namespace App\Repository;

use App\Entity\AnswerTutorial;
use App\Entity\Tutorial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnswerTutorial|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerTutorial|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerTutorial[]    findAll()
 * @method AnswerTutorial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerTutorialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnswerTutorial::class);
    }
}
