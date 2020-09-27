<?php

namespace App\Repository;

use App\Entity\EventRepeat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventRepeat|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRepeat|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRepeat[]    findAll()
 * @method EventRepeat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRepeat::class);
    }

    // /**
    //  * @return EventRepeat[] Returns an array of EventRepeat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventRepeat
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
