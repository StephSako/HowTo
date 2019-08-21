<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\AnswerForumRepository;
use App\Repository\AnswerTutorialRepository;
use App\Repository\ForumReportingRepository;
use App\Repository\ForumRepository;
use App\Repository\InformationsRepository;
use App\Repository\SuggestionForumRepository;
use App\Repository\SuggestionTutorialRepository;
use App\Repository\TutorialReportingRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MyAccountController extends AbstractController {

    /**
     * @var TutorialRepository
     */
    private $tutorialRepository;
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    private $em;
    /**
     * @var AnswerTutorialRepository
     */
    private $answerTutorialRepository;
    /**
     * @var AnswerForumRepository
     */
    private $answerForumRepository;
    /**
     * @var SuggestionTutorialRepository
     */
    private $suggestionTutorialRepository;
    /**
     * @var SuggestionForumRepository
     */
    private $suggestionForumRepository;
    /**
     * @var TutorialReportingRepository
     */
    private $tutorialReportingRepository;
    /**
     * @var ForumReportingRepository
     */
    private $forumReportingRepository;
    /**
     * @var InformationsRepository
     */
    private $informationsRepository;

    public function __construct(InformationsRepository $informationsRepository, TutorialReportingRepository $tutorialReportingRepository, ForumReportingRepository $forumReportingRepository, SuggestionTutorialRepository $suggestionTutorialRepository, SuggestionForumRepository $suggestionForumRepository, AnswerTutorialRepository $answerTutorialRepository, AnswerForumRepository $answerForumRepository, TutorialRepository $tutorialRepository, ForumRepository $forumRepository, ObjectManager $em)
    {
        $this->tutorialRepository = $tutorialRepository;
        $this->forumRepository = $forumRepository;
        $this->em = $em;
        $this->answerTutorialRepository = $answerTutorialRepository;
        $this->answerForumRepository = $answerForumRepository;
        $this->suggestionTutorialRepository = $suggestionTutorialRepository;
        $this->suggestionForumRepository = $suggestionForumRepository;
        $this->tutorialReportingRepository = $tutorialReportingRepository;
        $this->forumReportingRepository = $forumReportingRepository;
        $this->informationsRepository = $informationsRepository;
    }

    /**
     * @Route("/compte", name="myaccount.home")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function home(Request $request, UserPasswordEncoderInterface $encoder){
        $user = $this->getUser();
        $own_tutorials = $this->tutorialRepository->findBy(['idUser' => $this->getUser()->getId()]);
        $own_forums = $this->forumRepository->findBy(['idUser' => $this->getUser()->getId()]);
        $own_answers_forums = $this->answerForumRepository->findBy(['idUser' => $this->getUser()->getId()]);
        $own_answers_tutorials = $this->answerTutorialRepository->findBy(['idUser' => $this->getUser()->getId()]);
        $own_suggestions_tutos = $this->suggestionTutorialRepository->FindOwnSuggestionsTutorial($this->getUser());
        $own_suggestions_forums = $this->suggestionForumRepository->FindOwnSuggestionsForum($this->getUser());

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->em->flush();
            $this->addFlash('success', 'Informations modifiées avec succès');
            return $this->redirect($request->getUri());
        }

        return $this->render('pages/account.html.twig', [
            'own_tutorials' => $own_tutorials,
            'own_forums' => $own_forums,
            'own_answers_forums' => $own_answers_forums,
            'own_answers_tutorials' => $own_answers_tutorials,
            'own_suggestions_tutos' => $own_suggestions_tutos,
            'own_suggestions_forums' => $own_suggestions_forums,
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

}