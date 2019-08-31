<?php

namespace App\Controller;

use App\Controller\PanelData\Categories;
use App\Controller\PanelData\LatestPosts;
use App\Repository\ForumRepository;
use App\Repository\LikeTutorialRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var TutorialRepository
     */
    private $tr;
    /**
     * @var ForumRepository
     */
    private $fr;
    private $categories;
    private $latest_posts_forums;
    private $latest_posts_tutorials;
    /**
     * @var LikeTutorialRepository
     */
    private $ltr;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em, LatestPosts $latestPosts, Categories $categories, TutorialRepository $tr, ForumRepository $fr, LikeTutorialRepository $ltr)
    {
        $this->tr = $tr;
        $this->fr = $fr;
        $this->ltr = $ltr;
        $this->em = $em;

        // Panneaux latéraux
        $this->categories = $categories->getCategories();
        $this->latest_posts_tutorials = $latestPosts->getLatestPostsTutorials();
        $this->latest_posts_forums = $latestPosts->getLatestPostsForums();
    }

    /**
     * @Route("/", name="home.tutorials")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function tutorials(PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $this->tr->findAllTutos(), /* query, NOT result */
            $request->query->getInt('page', 1),8);

        return $this->render('pages/homes.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'posts' => $posts,
            'current_menu' => 'tutorial'
        ]);
    }

    /**
     * @Route("/forums", name="home.forums")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function forums(PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $this->fr->findAllForums(), /* query, NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

        return $this->render('pages/homes.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'posts' => $posts,
            'current_menu' => 'forum'
        ]);
    }
}