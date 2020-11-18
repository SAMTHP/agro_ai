<?php

namespace App\Repository;

use App\Entity\ProjectLot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectLot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectLot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectLot[]    findAll()
 * @method ProjectLot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectLotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectLot::class);
    }

    // /**
    //  * @return ProjectLot[] Returns an array of ProjectLot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectLot
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
