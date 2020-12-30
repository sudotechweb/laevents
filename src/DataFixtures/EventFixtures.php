<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\EventDates;
use App\Repository\AssociationRepository;
use App\Repository\CategoryRepository;
use App\Service\RandomTextGenerator;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    private $randomtext;
    private $catRepo;
    private $assocRepo;
    public function __construct(RandomTextGenerator $randomTextGenerator, CategoryRepository $categoryRepository, AssociationRepository $associationRepository)
    {
        $this->randomtext = $randomTextGenerator;
        $this->assocRepo = $associationRepository;
        $this->catRepo = $categoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        $years = ['2020','2021'];
        foreach ($years as $year) {
            for ($h=0; $h < 3; $h++) { 
                for ($i=1; $i <= 12; $i++) {
                    for ($j=0; $j < 28; $j++) { 
                        $randomDate = rand(1,27);
                        if ($randomDate === $j) {
                            $currentRandomDate = $year.'-'.$i.'-'.$randomDate;
                            $event = new Event();
                            $eventDate = new EventDates();
                            $eventDate
                                // ->setEvent($event)
                                ->setEventDate(new DateTime($currentRandomDate, new DateTimeZone('Pacific/Port_Moresby')))
                                ->setAllday(rand(0,1))
                                // set random starting time
                                ->setStartingTime(new DateTime($currentRandomDate, new DateTimeZone('Pacific/Port_Moresby')))
                                // set random ending time
                                ->setEndingTime(new DateTime($currentRandomDate, new DateTimeZone('Pacific/Port_Moresby')))
                            ;
                            $event
                                ->setTitle($this->randomtext->randomTitle())
                                ->setDescription($this->randomtext->randomSentence())
                                ->setVenue($this->randomtext->randomTitle())
                                ->setPublish(true)
                                ->setImageFilename('events/yellow/iicjnnofyfuvjyz0voil')
                                ->addEventDate($eventDate)
                                ->setCategory($this->catRepo->findOneBy(['id'=>rand(221,231)]))
                                ->setAssociation($this->assocRepo->findOneBy(['id'=>rand(8,10)]))
                            ;
                            $manager->persist($eventDate);
                            $manager->persist($event);
                        }
                    }
                }
            }
        }

        $manager->flush();
    }
}
