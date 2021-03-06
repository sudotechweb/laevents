<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use DateInterval;
use DateTime;
use DateTimeZone;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeController extends AbstractController
{
    private $seo;
    public function __construct(SeoPageInterface $seo)
    {
        $this->seo = $seo;
    }
    
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $eventRepository, CategoryRepository $categoryRepository)
    {
        $this->seo
            ->addTitle('Home')
            ->addMeta('property', 'og:title', 'Home')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('home', [], UrlGeneratorInterface::ABSOLUTE_URL))
        ;
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
            'categories' => $categoryRepository->findAll(),
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
        $this->seo
            ->addTitle('About Us')
            ->addMeta('name', 'description', 'Lae, the capital of Morobe Province and the gateway to the Highland Provinces, is the second largest City in Papua New Guinea with a population of around 350,000 people (preliminary figures from the year 2011 census).')
            ->addMeta('property', 'og:title', 'About Us')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('about', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', 'Lae, the capital of Morobe Province and the gateway to the Highland Provinces, is the second largest City in Papua New Guinea with a population of around 350,000 people (preliminary figures from the year 2011 census).')
        ;
        return $this->render('home/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        $this->seo
            ->addTitle('Contact Us')
            ->addMeta('name', 'description', 'We love getting feedback. Please leave a review or suggestion through our contact page.')
            ->addMeta('property', 'og:title', 'Contact Us')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('contact', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', 'We love getting feedback. Please leave a review or suggestion through our contact page.')
        ;
        return $this->render('home/contact.html.twig');
    }
}
