<?php

namespace App\Controller;

use App\Entity\AnswerForum;
use App\Entity\Category;
use App\Entity\Forum;
use App\Entity\LikeForum;
use App\Entity\Tutorial;
use App\Form\AnswerForumType;
use App\Form\ForumType;
use App\Repository\AnswerForumRepository;
use App\Repository\CategoryRepository;
use App\Repository\ForumRepository;
use App\Repository\LikeForumRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumsController extends AbstractController
{

    /**
     * @var CategoryRepository
     */
    private $cr;
    /**
     * @var ForumRepository
     */
    private $fr;
    /**
     * @var Category[]
     */
    private $categories;
    /**
     * @var Tutorial[]|array
     */
    private $latest_posts_tutorials;
    /**
     * @var Forum[]|array
     */
    private $latest_posts_forums;
    /**
     * @var AnswerForumRepository
     */
    private $afr;
    /**
     * @var TutorialRepository
     */
    private $tr;
    /**
     * @var LikeForumRepository
     */
    private $lfr;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em, LikeForumRepository $lfr, CategoryRepository $cr, TutorialRepository $tr, ForumRepository $fr, AnswerForumRepository $afr)
    {
        $this->cr = $cr;
        $this->tr = $tr;
        $this->fr = $fr;
        $this->afr = $afr;
        $this->lfr = $lfr;
        $this->em = $em;

        // Panneaux latéraux
        $this->categories = $this->cr->findBy(array(), array('label' => 'ASC'));
        $this->latest_posts_tutorials = $this->tr->findTutorials_OB_L(8, 'datecreation');
        $this->latest_posts_forums = $this->fr->findForums_OB_L(8, 'datecreation');
    }

    /**
     * @Route("/forum/{id}-{slug}", name="forum.details", requirements={"slug: [a-z0-9\-]*"})
     * @param Request $request
     * @param Forum $forum
     * @return Response
     * @throws NonUniqueResultException
     */
    public function details(Request $request, Forum $forum): Response
    {
        $details_post = $this->fr->find($forum);
        $nbLikes = $this->lfr->getNbLikes($forum);

        if ($this->get('security.token_storage')->getToken()->getUser() != "anon.") {
            if (empty($likes_by_user = $this->lfr->findBy(array('idForum' => $forum, 'idUser' => $this->get('security.token_storage')->getToken()->getUser()->getId()))))
                $has_liked = false;
            else $has_liked = true;
        } else $has_liked = false;

        $answers_post = $this->afr->findAnswerForums($forum);

        $comment = new AnswerForum($this->getUser(), $forum);
        $form = $this->createForm(AnswerForumType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($comment);
            $this->em->flush();
            return $this->redirectToRoute('forum.details',
                array(
                    'id' => $forum->getId(),
                    'slug' => $forum->getSlug()
                ));
        }

        return $this->render('pages/show_post.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'details_post' => $details_post,
            'nb_likes' => $nbLikes,
            'has_liked' => $has_liked,
            'answers_post' => $answers_post,
            'type' => 'forum',
            'form' => $form->createView(),
            'comment' => $comment
        ]);
    }

    /**
     * @Route("/forum/create", name="forum.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $forum = new Forum($this->getUser());
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($forum);
            $this->em->flush();
            return $this->redirectToRoute('forums.showForums');
        }

        return $this->render('pages/new.html.twig', [
            'forum' => $forum,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum/like/{id}", name="forum.like")
     * @param Forum $forum
     * @return Response
     */
    public function like(Forum $forum)
    {
        $likeforum = new LikeForum($this->getUser(), $forum);
        $this->em->persist($likeforum);
        $this->em->flush();
        return $this->redirectToRoute('forum.details',
            array(
                'id' => $forum->getId(),
                'slug' => $forum->getSlug()
            ));
    }

    /**
     * @Route("/forum/unlike/{id}", name="forum.unlike")
     * @param Forum $forum
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function unlike(Forum $forum)
    {
        $likeforum = $this->lfr->findForumLiked($this->getUser(), $forum);
        $this->em->remove($likeforum);
        $this->em->flush();
        return $this->redirectToRoute('forum.details',
            array(
                'id' => $forum->getId(),
                'slug' => $forum->getSlug()
            ));
    }
}