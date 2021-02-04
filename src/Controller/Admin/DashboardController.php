<?php
namespace App\Controller\Admin;

use App\Entity\Appuser;
use App\Entity\Association;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(EventCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App Administration Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Exit dashboard','fa fa-exit','/');
        yield MenuItem::linktoDashboard('Events', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fa fa-cross', Category::class);
        yield MenuItem::linkToCrud('Association', 'fa fa-key', Association::class);
        yield MenuItem::linkToCrud('User', 'fa fa-user', Appuser::class);
    }
}
