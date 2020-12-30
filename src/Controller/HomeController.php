<?php

namespace App\Controller;

use App\Repository\EventRepository;
use DateInterval;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $eventRepository)
    {
        $currentDate = new DateTime('now', new DateTimeZone('Pacific/Port_Moresby'));
        $nextMonthDate = new DateTime('now', new DateTimeZone('Pacific/Port_Moresby'));
        $nextMonthDate->modify('first day of next month');
        $events = $eventRepository->findByEventMonth($currentDate);
        // $events = $eventRepository->findBy(['id'=>11]);
        // $nextMonthDate === 13 ? $nextMonthDate = new DateTime($currentDate->format('y')+1.'-01-01', new DateTimeZone('Pacific/Port_Moresby'))
        // dump($nextMonthDate->format('t F Y'),date('d M Y',strtotime('now'))); exit;
        // dump($nextMonthDate); exit;
        // $nextMonthDate = $nextMonthDate->format('Y-m-d');
        return $this->render('home/index.html.twig', [
            'events' => $events,
            'nextMonthEvents' => $eventRepository->findByEventMonth($nextMonthDate),
        ]);
    }

    /**
     * @Route("/month/", name="monthly_view", methods={"GET"})
     */
    public function monthly_view(EventRepository $eventRepository, Request $request): Response
    {
        $currentDate = new DateTime($request->get('monthly_view'), new DateTimeZone('Pacific/Port_Moresby'));
        $nextMonthDate = new DateTime($request->get('monthly_view'), new DateTimeZone('Pacific/Port_Moresby'));
        $nextMonthDate->modify('first day of next month');
        $events = $eventRepository->findByEventMonth($currentDate);
        // dump($nextMonthDate); exit;
        // $events = $eventRepository->findBy(['id'=>11]);
        // $nextMonthDate === 13 ? $nextMonthDate = new DateTime($currentDate->format('y')+1.'-01-01', new DateTimeZone('Pacific/Port_Moresby'))
        // dump($nextMonthDate->format('t F Y'),date('d M Y',strtotime('now'))); exit;
        // $nextMonthDate = $nextMonthDate->format('Y-m-d');
        return $this->render('home/index.html.twig', [
            'events' => $events,
            'currentMonth' => $currentDate,
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
