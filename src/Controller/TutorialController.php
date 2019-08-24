<?php

namespace App\Controller;

use App\Entity\AnswerTutorial;
use App\Entity\LikeTutorial;
use App\Entity\Tutorial;
use App\Form\AnswerTutorialType;
use App\Form\TutorialType;
use App\Repository\AnswerTutorialRepository;
use App\Repository\CategoryRepository;
use App\Repository\ForumRepository;
use App\Repository\LikeTutorialRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TutorialController extends AbstractController
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

    public function __construct(ObjectManager $em, LikeTutorialRepository $ltr, CategoryRepository $cr, TutorialRepository $tr, ForumRepository $fr, AnswerTutorialRepository $atr)
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
     * @Route("/tutorial/{id}-{slug}", name="tutorial.details", requirements={"slug: [a-z0-9\-]*"})
     * @param Tutorial $tutorial
     * @param Request $request
     * @return Response
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function details(Tutorial $tutorial, Request $request) :Response
    {
        $details_post = $this->tr->find($tutorial);
        $nbLikes = $this->ltr->getNbLikes($tutorial);

        $has_liked = false;

        if ($this->get('security.token_storage')->getToken()->getUser() != "anon.") {
            if (!empty($likes_by_user = $this->ltr->findBy(array('idTutorial' => $tutorial, 'idUser' => $this->get('security.token_storage')->getToken()->getUser()->getId()))))
                $has_liked = true;
        }

        $answers_post = $this->atr->findBy(array('idTutorial' => $tutorial), array('dateresponse' => 'ASC'));
        $comment = new AnswerTutorial($this->getUser(), $tutorial);
        $form = $this->createForm(AnswerTutorialType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($comment);
            $this->em->flush();
            return $this->redirect($request->getUri());
        }

        return $this->render('pages/show_post.html.twig', [
            'categories' => $this->categories,
            'latest_posts_tutorials' => $this->latest_posts_tutorials,
            'latest_posts_forums' => $this->latest_posts_forums,
            'details_post' => $details_post,
            'nb_likes' => $nbLikes,
            'has_liked' => $has_liked,
            'answers_post' => $answers_post,
            'type' => 'tutorial',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tutorial/create", name="tutorial.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $tutorial = new Tutorial($this->getUser());
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($tutorial);
            $this->em->flush();
            $this->addFlash('success', 'Tutoriel créé avec succès !');
            return $this->redirectToRoute('home.tutorials');
        }

        return $this->render('pages/new.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tutorial/like/{id}", name="tutorial.like")
     * @param Tutorial $tutorial
     * @return Response
     */
    public function like(Tutorial $tutorial){
        $liketutorial = new LikeTutorial($this->getUser(), $tutorial);
        $this->em->persist($liketutorial);
        $this->em->flush();
        return $this->redirectToRoute('tutorial.details',
            array(
                'id' => $tutorial->getId(),
                'slug' => $tutorial->getSlug()
            ));
    }

    /**
     * @Route("/tutorial/unlike/{id}", name="tutorial.unlike")
     * @param Tutorial $tutorial
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function unlike(Tutorial $tutorial){
        $liketutorial = $this->ltr->findTutoLiked($this->getUser(), $tutorial);
        $this->em->remove($liketutorial);
        $this->em->flush();
        return $this->redirectToRoute('tutorial.details',
            array(
                'id' => $tutorial->getId(),
                'slug' => $tutorial->getSlug()
            ));
    }
}
