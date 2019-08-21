<?php

namespace App\Repository;

use App\Entity\ReportingLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReportingLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportingLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportingLabel[]    findAll()
 * @method ReportingLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportingLabelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReportingLabel::class);
    }
}
