<?php

namespace App\Controller;

use App\Entity\SuggestionForum;
use App\Entity\SuggestionTutorial;
use App\Repository\SuggestionForumRepository;
use App\Repository\SuggestionTutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public function __construct(ObjectManager $em, SuggestionTutorialRepository $suggestionTutorialRepository, SuggestionForumRepository $suggestionForumRepository)
    {
        $this->em = $em;
        $this->suggestionTutorialRepository = $suggestionTutorialRepository;
        $this->suggestionForumRepository = $suggestionForumRepository;
    }

    /**
     * @Route("/tutorial/suggestion/delete/{id}", name="tutorial.suggestion.deleteSuggTuto", methods={"DELETE"})
     * @param SuggestionTutorial $suggestionTutorial
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteSuggTuto(SuggestionTutorial $suggestionTutorial, Request $request)
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
     * @Route("/forum/suggestion/delete/{id}", name="forum.suggestion.deleteSuggFor", methods={"DELETE"})
     * @param SuggestionForum $suggestionForum
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteSuggFor(SuggestionForum $suggestionForum, Request $request)
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
