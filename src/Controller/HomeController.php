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
        //     $dbref = $db->getReference('test');
        //     return $this->render('home/index.html.twig', [
        //         'test' => $dbref->getValue(),
        //         'events' => $db->getReference('events')->getValue(),
        //     ]);
        // }
        return $this->redirectToRoute('event_index');
    }
}
