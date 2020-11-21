<?php

namespace App\Controller;

use App\Repository\EventRepository;
use DateInterval;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $eventRepository)
    {
        $currentDate = new DateTime('now', new DateTimeZone('Pacific/Port_Moresby'));
        $nextMonthDate = date_add(new DateTime('now'), new DateInterval('P1M'));
        // $nextMonthDate === 13 ? $nextMonthDate = new DateTime($currentDate->format('y')+1.'-01-01', new DateTimeZone('Pacific/Port_Moresby'))
        // dump($nextMonthDate); exit;
        return $this->render('home/index.html.twig', [
            'events' => $eventRepository->findByEventMonth($currentDate),
            'nextMonthEvents' => $eventRepository->findByEventMonth($nextMonthDate),
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('home/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig');
    }
}
