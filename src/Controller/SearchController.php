<?php

namespace App\Controller;

use App\Controller\PanelData\Categories;
use App\Controller\PanelData\LatestPosts;
use App\Entity\Category;
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
     * @var Category[]|array
     */
    private $categories;

    public function __construct(ObjectManager $em, LatestPosts $latestPosts, Categories $categories, TutorialRepository $tutorialRepository, ForumRepository $forumRepository, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->tutorialRepository = $tutorialRepository;
        $this->forumRepository = $forumRepository;
        $this->userRepository = $userRepository;

        $this->categories = $categories->getCategories();
        $this->latest_posts_tutorials = $latestPosts->getLatestPostsTutorials();
        $this->latest_posts_forums = $latestPosts->getLatestPostsForums();
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
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'searched_tutos' => $searched_tutos,
            'searched_forums' => $searched_forums,
            'searched_users' => $searched_users,
            'keyword' => $keyword
        ]);
    }
}