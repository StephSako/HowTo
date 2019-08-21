<?php

namespace App\Controller\Admin;

use App\Repository\ForumRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

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

    public function __construct(TutorialRepository $tr, ForumRepository $fr, ObjectManager $em){
        $this->tr = $tr;
        $this->em = $em;
        $this->fr = $fr;
    }

    /**
     * @Route("/admin", name="admin.home.index")
     * @return Response
     */
    public function index() : Response
    {
        $tutorials = $this->tr->findAll();
        $forums = $this->fr->findAll();
        return $this->render('admin/home.html.twig', [
            'tutorials' => $tutorials,
            'forums' => $forums,
            'current_menu' => 'posts'
        ]);
    }
}