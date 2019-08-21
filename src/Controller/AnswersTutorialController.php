<?php

namespace App\Controller;

use App\Entity\AnswerTutorial;
use App\Repository\AnswerTutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswersTutorialController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var AnswerTutorialRepository
     */
    private $atr;

    public function __construct(AnswerTutorialRepository $atr, ObjectManager $em){
        $this->atr = $atr;
        $this->em = $em;
    }

    /**
     * @Route("/tutorial/comment/delete/{id}", name="tutorial.comment.delete", methods={"DELETE"})
     * @param AnswerTutorial $answerTutorial
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(AnswerTutorial $answerTutorial, Request $request){
        if ($this->isCsrfTokenValid('delete' . $answerTutorial->getId(), $request->get('_token'))){
            $this->em->remove($answerTutorial);
            $this->em->flush();
            $this->addFlash('success', 'Commentaire supprimé');
            return $this->redirectToRoute('myaccount.home');
        }
        else{
            $this->addFlash('error', "Le commentaire n'a pas été supprimé !");
            return $this->redirectToRoute('myaccount.home');
        }
    }
}