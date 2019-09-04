<?php

namespace App\Controller;

use App\Controller\PanelData\Categories;
use App\Controller\PanelData\LatestPosts;
use App\Entity\Tutorial;
use App\Entity\User;
use App\Form\TutorialType;
use App\Repository\ForumRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $categories;
    private $latest_posts_forums;
    private $latest_posts_tutorials;
    /**
     * @var TutorialRepository
     */
    private $tr;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var ForumRepository
     */
    private $fr;

    public function __construct( Categories $categories, TutorialRepository $tutorialRepository, LatestPosts $latestPosts, ForumRepository $forumRepository)
    {
        $this->tr = $tutorialRepository;
        $this->fr = $forumRepository;

        // Panneaux latéraux
        $this->categories = $categories->getCategories();
        $this->latest_posts_tutorials = $latestPosts->getLatestPostsTutorials();
        $this->latest_posts_forums = $latestPosts->getLatestPostsForums();
    }

    /**
     * @Route("/user/{id}/posts", name="posts.createdBy")
     * @param User $id
     * @return Response
     */
    public function createdBy(User $id):Response
    {
        $tutorials = $this->tr->findBy(array('idUser' => $id), array('datecreation' => 'ASC'));
        $forums = $this->fr->findBy(array('idUser' => $id), array('datecreation' => 'ASC'));

        return $this->render('pages/postsPerUser.html.twig', [
            'tutorials' => $tutorials,
            'forums' => $forums,
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'user' => $id->getFirstname().' '.$id->getLastname()
        ]);
    }
}
