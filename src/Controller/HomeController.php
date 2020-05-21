<?php

namespace App\Controller;

use Kreait\Firebase\Database;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Database $db)
    {
        $dbref = $db->getReference('test');
        return $this->render('home/index.html.twig', [
            'test' => $dbref->getValue(),
            'events' => $db->getReference('events')->getValue(),
        ]);
    }
}
