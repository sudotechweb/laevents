<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $eventRepository)
    {
        // if ($db != null) {
            // $dbref = $db->getReference('test');
            return $this->render('home/index.html.twig', [
                'events' => $eventRepository->findAll(),
                // 'test' => $dbref->getValue(),
            ]);
        // }
        return $this->redirectToRoute('event_index');
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
