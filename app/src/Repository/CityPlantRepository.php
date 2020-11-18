<?php

namespace App\Repository;

use App\Entity\CityPlant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CityPlant|null find($id, $lockMode = null, $lockVersion = null)
 * @method CityPlant|null findOneBy(array $criteria, array $orderBy = null)
 * @method CityPlant[]    findAll()
 * @method CityPlant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityPlantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CityPlant::class);
    }

    // /**
    //  * @return CityPlant[] Returns an array of CityPlant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CityPlant
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
