<?php

namespace App\Controller;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use App\Repository\EventRepository;
use App\Service\AdminVoterService;
use App\Service\FileUploader;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/association")
 */
class AssociationController extends AbstractController
{
    private $seo;
    public function __construct(SeoPageInterface $seo)
    {
        $this->seo = $seo;
    }
    
    /**
     * @Route("/", name="association_index", methods={"GET"})
     */
    public function index(AssociationRepository $associationRepository): Response
    {
        $this->seo
            ->addTitle('Associations & Clubs')
            ->addMeta('name', 'description', 'These are the different clubs and associations found within Lae city.')
            ->addMeta('property', 'og:title', 'Associations & Events')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('association_index', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', 'These are the different clubs and associations found within Lae city.')
        ;
        return $this->render('association/index.html.twig', [
            'associations' => $associationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="association_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

        $association = new Association();
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logoImage')->getData();
            if ( $logoFile) {
                $logoFileName = $fileUploader->upload($logoFile);
                $association->setLogoFileName($logoFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirectToRoute('association_new');
        }

        return $this->render('association/new.html.twig', [
            'association' => $association,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="association_show", methods={"GET"})
     */
    public function show(Association $association, EventRepository $eventRepository): Response
    {
        $this->seo
            ->addTitle($association->getName())
            ->addMeta('name', 'description', $association->getDescription())
            ->addMeta('property', 'og:title', $association->getName())
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('association_show', ['id'=>$association->getId()], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', $association->getDescription())
        ;
        $events = $eventRepository->findBy(['publish'=>true, 'association'=>$association],['id'=>'desc']);
        return $this->render('association/show.html.twig', [
            'association' => $association,
            'events' => $events,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="association_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Association $association, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('association_index');
        }

        return $this->render('association/edit.html.twig', [
            'association' => $association,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="association_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Association $association, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

        if ($this->isCsrfTokenValid('delete'.$association->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('association_index');
    }
}
