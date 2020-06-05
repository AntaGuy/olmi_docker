<?php

namespace App\Repository;

use App\Entity\Aid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aid[]    findAll()
 * @method Aid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aid::class);
    }

    /**
     * @param $value
     * @return Aid|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySlug($value): ?Aid
    {
        return $this->createQueryBuilder('a')
                    ->innerJoin('a.page', 'p')
                    ->andWhere('p.slug = :val')
                    ->setParameter('val', $value)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @return Aid[] Returns an array of Aid objects
     */
    public function findByEnabled()
    {
        return $this->createQueryBuilder('a')
                    ->innerJoin('a.page', 'p')
                    ->andWhere('p.enabled = 1')
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Aid[] Returns an array of Aid objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aid
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
