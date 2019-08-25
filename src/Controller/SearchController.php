<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ForumRepository;
use App\Repository\TutorialRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var TutorialRepository
     */
    private $tutorialRepository;
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $latest_posts_forums;
    private $latest_posts_tutorials;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(ObjectManager $em, CategoryRepository $categoryRepository, TutorialRepository $tutorialRepository, ForumRepository $forumRepository, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->tutorialRepository = $tutorialRepository;
        $this->forumRepository = $forumRepository;
        $this->userRepository = $userRepository;

        $this->latest_posts_tutorials = $this->tutorialRepository->findTutorials_OB_L(8, 'datecreation');
        $this->latest_posts_forums = $this->forumRepository->findForums_OB_L(8, 'datecreation');
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/search/", name="search.index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $keyword = $request->query->get('search');
        $searched_tutos = $this->tutorialRepository->findSearchedTutorials($keyword);
        $searched_forums = $this->forumRepository->findSearchedForums($keyword);
        $searched_users = $this->userRepository->findSearchedUsers($keyword);

        return $this->render('pages/search.html.twig',[
            'categories' => $this->categoryRepository->findBy(array(), array('label' => 'ASC')),
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'searched_tutos' => $searched_tutos,
            'searched_forums' => $searched_forums,
            'searched_users' => $searched_users,
            'keyword' => $keyword
        ]);
    }
}