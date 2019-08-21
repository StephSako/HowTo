<?php

namespace App\Repository;

use App\Entity\TutorialReporting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TutorialReporting|null find($id, $lockMode = null, $lockVersion = null)
 * @method TutorialReporting|null findOneBy(array $criteria, array $orderBy = null)
 * @method TutorialReporting[]    findAll()
 * @method TutorialReporting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutorialReportingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TutorialReporting::class);
    }
}
