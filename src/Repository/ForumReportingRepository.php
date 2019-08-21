<?php

namespace App\Repository;

use App\Entity\ForumReporting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ForumReporting|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumReporting|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumReporting[]    findAll()
 * @method ForumReporting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumReportingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ForumReporting::class);
    }
}
