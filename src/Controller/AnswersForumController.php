<?php

namespace App\Controller;

use App\Entity\AnswerForum;
use App\Repository\AnswerForumRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswersForumController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var AnswerForumRepository
     */
    private $answerForumRepository;

    public function __construct(AnswerForumRepository $answerForumRepository, ObjectManager $em){
        $this->answerForumRepository = $answerForumRepository;
        $this->em = $em;
    }

    /**
     * @Route("/forum/comment/delete/{id}", name="forum.comment.delete", methods={"DELETE"})
     * @param AnswerForum $answerForum
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(AnswerForum $answerForum, Request $request){
        if ($this->isCsrfTokenValid('delete' . $answerForum->getId(), $request->get('_token'))){
            $this->em->remove($answerForum);
            $this->em->flush();
            $this->addFlash('success', 'Commentaire supprimé');
        }
        else{
            $this->addFlash('error', "Le commentaire n'a pas été supprimé !");
        }
        return $this->redirectToRoute('myaccount.home');
    }
}