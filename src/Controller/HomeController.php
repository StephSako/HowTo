<?php

namespace App\Controller;

use App\Repository\AnswerTutorialRepository;
use App\Repository\CategoryRepository;
use App\Repository\ForumRepository;
use App\Repository\LikeTutorialRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

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
     * @return Response
     */
    public function tutorials() : Response
    {
        $all = $this->tr->findAll();

        return $this->render('pages/homes.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'all' => $all,
            'current_menu' => 'tutorial'
        ]);
    }

    /**
     * @Route("/forums", name="home.forums")
     * @return Response
     */
    public function forums() : Response
    {
        $all = $this->fr->findAll();

        return $this->render('pages/homes.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'all' => $all,
            'current_menu' => 'forum'
        ]);
    }
}