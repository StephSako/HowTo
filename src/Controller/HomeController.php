<?php

namespace App\Controller;

use App\Repository\AnswerTutorialRepository;
use App\Repository\CategoryRepository;
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
     * @var AnswerTutorialRepository
     */
    private $atr;
    /**
     * @var TutorialRepository
     */
    private $tr;
    /**
     * @var CategoryRepository
     */
    private $cr;
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

    public function __construct(ObjectManager $em, CategoryRepository $cr, TutorialRepository $tr, ForumRepository $fr, AnswerTutorialRepository $atr, LikeTutorialRepository $ltr)
    {
        $this->cr = $cr;
        $this->tr = $tr;
        $this->fr = $fr;
        $this->atr = $atr;
        $this->ltr = $ltr;
        $this->em = $em;

        // Panneaux latéraux
        $this->categories = $this->cr->findBy(array(), array('label' => 'ASC'));
        $this->latest_posts_tutorials = $this->tr->findTutorials_OB_L(8, 'datecreation');
        $this->latest_posts_forums = $this->fr->findForums_OB_L(8, 'datecreation');
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
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

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