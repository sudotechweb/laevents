<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\AssociationRepository;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findBy(['publish'=>true]),
        ]);
    }

    /**
     * @Route("/category", name="event_category_index", methods={"GET"})
     */
    public function category(EventRepository $eventRepository, CategoryRepository $categoryRepository): Response
    {
        $events = $eventRepository->findBy(['publish'=>true]);
        $categories = $categoryRepository->findAll();
        $eArray = [];
        foreach ($categories as $cat) {
            $catName = $cat->getName();
            $eArray[$catName] = [];
            foreach ($events as $event) {
                if ($event->getCategory()->getName() === $catName) {
                    // var_dump($event->getCategory()->getName());// exit;
                    // $eArray = $event;
                    array_push($eArray[$catName], $event);
                }
            }
        }
        // exit;
        return $this->render('event/index.topics.html.twig', [
            'events' => $eArray,
        ]);
    }

    /**
     * @Route("/association", name="event_association_index", methods={"GET"})
     */
    public function association(EventRepository $eventRepository, AssociationRepository $associationRepository): Response
    {
        $events = $eventRepository->findBy(['publish'=>true]);
        $assocs = $associationRepository->findAll();
        $eArray = [];
        foreach ($assocs as $assoc) {
            $assocName = $assoc->getName();
            $eArray[$assocName] = [];
            foreach ($events as $event) {
                if ($event->getAssociation()->getName() === $assocName) {
                    // var_dump($event->getCategory()->getName());// exit;
                    // $eArray = $event;
                    array_push($eArray[$assocName], $event);
                }
            }
        }
        // exit;
        return $this->render('event/index.associations.html.twig', [
            'events' => $eArray,
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $refPath = 'events/'.$event->getId().'/';
            // $dbref = $db->getReference($refPath);
            // $dbref
            //     ->push([
            //         'title' => $form->getData()->getTitle(),
            //         'description' => $form->getData()->getDescription(),
            //         'venue' => $form->getData()->getVenue(),
            //         'Start' => date_format($form->getData()->getStart(), 'd-m-y'),
            //         'End' => date_format($form->getData()->getEnd(), 'd-m-y'),
            //     ])
            // ;
            $featuredFile = $form->get('featuredImage')->getData();
            if ( $featuredFile) {
                $featuredFileName = $fileUploader->upload($featuredFile);
                $event->setImageFilename($featuredFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_show', ['id'=> $event->getId()]);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event, EventRepository $eventRepository): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'relatedEvents' => $eventRepository->findBy(['category'=>$event->getCategory()]),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $refPath = 'events/'.$event->getId().'/';
            // $dbref = $db->getReference($refPath);
            // $dbref->update([]);
            $featuredFile = $form->get('featuredImage')->getData();
            if ( $featuredFile) {
                $featuredFileName = $fileUploader->upload($featuredFile);
                $event->setImageFilename($featuredFileName);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('event_show', ['id'=>$event->getId()]);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
