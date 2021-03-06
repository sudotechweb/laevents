<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\AssociationRepository;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use App\Service\AdminVoterService;
use App\Service\FileUploader;
use DateTime;
use DateTimeZone;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    private $seo;
    public function __construct(SeoPageInterface $seo)
    {
        $this->seo = $seo;
    }
    
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $this->seo
            ->addTitle('Events')
            ->addMeta('name', 'description', 'These are the events which are published on our web application.')
            ->addMeta('property', 'og:title', 'Events')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('event_index', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', 'These are the broad category topics that we use to categorize all events here on our web application.')
        ;
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findBy(['publish'=>true]),
        ]);
    }

    /**
     * @Route("/api", name="json_api")
     */
    public function jsonAPI(EventRepository $eventRepository)
    {
        $export = [];
        foreach ($eventRepository->findByEventMonth(new DateTime('now', new DateTimeZone('Pacific/Port_Moresby'))) as $event) {
            array_push($export,[
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'url' => '#',
                'class' => 'event-important',
                'start' => date_timestamp_get($event->getEventDates()[0]->getEventDate()),
                'end' => date_timestamp_get($event->getEventDates()[0]->getEventDate()),
            ]);
        }
        return new JsonResponse($export);
    }

    /**
     * @Route("/category", name="event_category_index", methods={"GET"})
     */
    public function category(EventRepository $eventRepository, CategoryRepository $categoryRepository): Response
    {
        $events = $eventRepository->findBy(['publish'=>true],['id'=>'desc']);
        $categories = $categoryRepository->findAll();
        $fArray = [];
        foreach ($categories as $cat) {
            $catName = $cat->getName();
            // catevents = [category,events]
            $fArray[$catName]['category'] = $cat;
            $fArray[$catName]['events'] = [];
            $eventsCounter = 0;
            foreach ($events as $event) {
                if ($event->getCategory() === $cat) {
                    array_push($fArray[$catName]['events'], $event);
                    $eventsCounter++;
                }
                if ($eventsCounter == 5) {
                    break;
                }
            }
        }
        return $this->render('event/index.topics.html.twig', [
            'events' => $fArray,
        ]);
    }

    /**
     * @Route("/association", name="event_association_index", methods={"GET"})
     */
    public function association(EventRepository $eventRepository, AssociationRepository $associationRepository): Response
    {
        $events = $eventRepository->findBy(['publish'=>true],['id'=>'desc']);
        $associations = $associationRepository->findAll();
        $eArray = [];
        foreach ($associations as $assoc) {
            $assocName = $assoc->getName();
            // assocevents = [assocegory,events]
            $eArray[$assocName]['association'] = $assoc;
            $eArray[$assocName]['events'] = [];
            $eventsCounter = 0;
            foreach ($events as $event) {
                if ($event->getAssociation() === $assoc) {
                    array_push($eArray[$assocName]['events'], $event);
                    $eventsCounter++;
                }
                if ($eventsCounter == 5){
                    break;
                }
            }
        }
        // dump($eArray); exit;
        return $this->render('event/index.associations.html.twig', [
            'events' => $eArray,
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $this->seo
            ->addTitle('Add New Event')
            ->addMeta('name', 'description', 'Use this form to register your event with us and we\'ll have it published on our site for you.')
            ->addMeta('property', 'og:title', 'Associations & Events')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('event_new', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', 'Use this form to register your event with us and we\'ll have it published on our site for you.')
        ;
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
            // if ($form->get('featuredImage')) {
            //     $featuredFile = $form->get('featuredImage')->getData();
            //     if ( $featuredFile) {
            //         $featuredFileName = $fileUploader->upload($featuredFile);
            //         $event->setImageFilename($featuredFileName);
            //     }
            // }
            $event->setPublish(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('home');
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
        $this->seo
            ->addTitle($event->getTitle())
            ->addMeta('name', 'description', $event->getDescription())
            ->addMeta('property', 'og:title', $event->getTitle())
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('event_show', ['id'=>$event->getId()], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', $event->getDescription())
        ;
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'relatedEvents' => $eventRepository->findBy(['publish'=>true,'category'=>$event->getCategory()],['id'=>'desc']),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event, FileUploader $fileUploader, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

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
    public function delete(Request $request, Event $event, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }
        
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
