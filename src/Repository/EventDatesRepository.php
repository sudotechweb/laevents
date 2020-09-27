<?php

namespace App\Repository;

use App\Entity\EventDates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventDates|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventDates|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventDates[]    findAll()
 * @method EventDates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventDatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventDates::class);
    }

    // /**
    //  * @return EventDates[] Returns an array of EventDates objects
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
    public function findOneBySomeField($value): ?EventDates
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
