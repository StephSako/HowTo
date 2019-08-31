<?php

namespace App\Controller;

use App\Controller\PanelData\Categories;
use App\Entity\Category;
use App\Entity\Forum;
use App\Entity\SuggestionForum;
use App\Entity\SuggestionTutorial;
use App\Entity\Tutorial;
use App\Form\SuggestionForumType;
use App\Form\SuggestionTutorialType;
use App\Repository\SuggestionForumRepository;
use App\Repository\SuggestionTutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuggestionsController extends AbstractController
{
    private $em;
    /**
     * @var SuggestionTutorialRepository
     */
    private $suggestionTutorialRepository;
    /**
     * @var SuggestionForumRepository
     */
    private $suggestionForumRepository;
    /**
     * @var Category[]|array
     */
    private $categories;

    /**
     * SuggestionsController constructor.
     * @param ObjectManager $em
     * @param Categories $categories
     * @param SuggestionTutorialRepository $suggestionTutorialRepository
     * @param SuggestionForumRepository $suggestionForumRepository
     */
    public function __construct(ObjectManager $em, Categories $categories, SuggestionTutorialRepository $suggestionTutorialRepository, SuggestionForumRepository $suggestionForumRepository)
    {
        $this->em = $em;
        $this->suggestionTutorialRepository = $suggestionTutorialRepository;
        $this->suggestionForumRepository = $suggestionForumRepository;
        $this->categories = $categories->getCategories();
    }

    /**
     * @Route("/forum/suggestion/{id}", name="newSuggestionforum")
     * @param Forum $forum
     * @param Request $request
     * @return Response
     */
    public function newSuggestionforum(Forum $forum, Request $request): Response
    {
        $suggestionForum = new SuggestionForum($this->getUser(), $forum);
        $form = $this->createForm(SuggestionForumType::class, $suggestionForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($suggestionForum);
            $this->em->flush();
            return $this->redirectToRoute('forum.details', [
                'id' => $forum->getId(),
                'slug' => $forum->getSlug()]);
        }

        return $this->render('pages/suggestion.html.twig', [
            'type' => 'forum',
            'post' => $forum,
            'categories' => $this->categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tutorial/suggestion/{id}", name="newSuggestiontutorial")
     * @param Tutorial $tutorial
     * @param Request $request
     * @return Response
     */
    public function newSuggestiontutorial(Tutorial $tutorial, Request $request): Response
    {
        $suggestionTutorial = new SuggestionTutorial($this->getUser(), $tutorial);
        $form = $this->createForm(SuggestionTutorialType::class, $suggestionTutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($suggestionTutorial);
            $this->em->flush();
            return $this->redirectToRoute('tutorial.details', [
                'id' => $tutorial->getId(),
                'slug' => $tutorial->getSlug()]);
        }

        return $this->render('pages/suggestion.html.twig', [
            'type' => 'tutorial',
            'post' => $tutorial,
            'categories' => $this->categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tutorial/suggestion/delete/{id}", name="deleteSuggestiontutorial", methods={"DELETE"})
     * @param SuggestionTutorial $suggestionTutorial
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteSuggestiontutorial(SuggestionTutorial $suggestionTutorial, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $suggestionTutorial->getId(), $request->get('_token'))) {
            $this->em->remove($suggestionTutorial);
            $this->em->flush();
            $this->addFlash('success', "Suggestion du tutoriel supprimée");
            return $this->redirectToRoute('myaccount.home');
        } else {
            $this->addFlash('error', "La suggestion du tutoriel n'a pas été supprimée !");
            return $this->redirectToRoute('myaccount.home');
        }
    }
    /**
     * @Route("/forum/suggestion/delete/{id}", name="deleteSuggestionforum", methods={"DELETE"})
     * @param SuggestionForum $suggestionForum
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteSuggestionforum(SuggestionForum $suggestionForum, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $suggestionForum->getId(), $request->get('_token'))) {
            $this->em->remove($suggestionForum);
            $this->em->flush();
            $this->addFlash('success', "Suggestion du forum supprimée");
            return $this->redirectToRoute('myaccount.home');
        } else {
            $this->addFlash('error', "La suggestion du forum n'a pas été supprimée !");
            return $this->redirectToRoute('myaccount.home');
        }
    }

}
