<?php

namespace App\Repository;

use App\Entity\EventPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventPhoto[]    findAll()
 * @method EventPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventPhoto::class);
    }

    // /**
    //  * @return EventPhoto[] Returns an array of EventPhoto objects
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
    public function findOneBySomeField($value): ?EventPhoto
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
