<?php

namespace App\Repository;

use App\Entity\PageBlockType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageBlockType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageBlockType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageBlockType[]    findAll()
 * @method PageBlockType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageBlockTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageBlockType::class);
    }

    // /**
    //  * @return PageBlockType[] Returns an array of PageBlockType objects
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
    public function findOneBySomeField($value): ?PageBlockType
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
