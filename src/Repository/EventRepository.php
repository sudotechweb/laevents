<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventDates;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return Event[] Returns an array of Event objects
     */
    public function findByEventMonth($value)
    {
        $startDate = $value->format('Y-m-01');
        $endDate = new DateTime($value->format('d-m-Y'), new DateTimeZone('Pacific/Port_Moresby'));
        // dump($startDate, $endDate->format('Y-m-t')); exit;
        return $this->createQueryBuilder('e')
            // ->andWhere('e. = :val')
            // ->setParameter('val', $value)
            ->where('e.publish = true')
            ->andWhere('d.eventDate between :startDate and :endDate')
            // ->andWhere('d.eventDate <= :endDate')
            ->setParameter('startDate',$startDate)
            ->setParameter('endDate',$endDate->format('Y-m-t'))
            // ->join('event_dates', 'd', 'ON', 'd.event_id=e.id')
            ->join('e.eventDates', 'd')
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Event
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
