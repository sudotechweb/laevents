<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\AdminVoterService;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    private $seo;
    public function __construct(SeoPageInterface $seo)
    {
        $this->seo = $seo;
    }
    
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $this->seo
            ->addTitle('Event Categories')
            ->addMeta('name', 'description', 'These are the broad category topics that we use to categorize all events here on our web application.')
            ->addMeta('property', 'og:title', 'Event Categories')
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('category_index', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', 'These are the broad category topics that we use to categorize all events here on our web application.')
        ;
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll2(),
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        $this->seo
            ->addTitle($category->getName())
            ->addMeta('name', 'description', $category->getDescription())
            ->addMeta('property', 'og:title', $category->getName())
            ->addMeta('property', 'og:type', 'blog')
            ->addMeta('property', 'og:url',  $this->generateUrl('category_show', ['id' => $category->getId()], UrlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description', $category->getDescription())
        ;
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category, AdminVoterService $adminVoterService): Response
    {
        if ($adminVoterService->isAdmin($this->getUser()->getRoles())) {
            return $this->redirectToRoute('home');
        }

        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }
}
