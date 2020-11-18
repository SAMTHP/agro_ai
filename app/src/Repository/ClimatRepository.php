<?php

namespace App\Repository;

use App\Entity\Climat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Climat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Climat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Climat[]    findAll()
 * @method Climat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClimatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Climat::class);
    }

    // /**
    //  * @return Climat[] Returns an array of Climat objects
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
    public function findOneBySomeField($value): ?Climat
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
