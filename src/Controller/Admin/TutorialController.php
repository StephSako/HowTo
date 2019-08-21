<?php

namespace App\Controller\Admin;

use App\Entity\Tutorial;
use App\Form\TutorialType;
use App\Repository\ForumRepository;
use App\Repository\TutorialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TutorialController extends AbstractController {

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
     * @Route("/admin/tutorial/create", name="admin.tutorial.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $tutorial = new Tutorial();
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($tutorial);
            $this->em->flush();
            $this->addFlash('success', 'Tutoriel créé avec succès !');
            return $this->redirectToRoute('admin.home.index');
        }

        return $this->render('pages/new.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tutorial/edit/{id}", name="admin.tutorial.edit")
     * @param Tutorial $tutorial
     * @param Request $request
     * @return Response
     */
    public function edit(Tutorial $tutorial, Request $request) : Response
    {
        $form = $this->createForm(TutorialType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Tutoriel modifié avec succès !');
            return $this->redirectToRoute('admin.home.index');
        }


        return $this->render('pages/edit.html.twig', [
            'tutorial' => $tutorial,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tutorial/delete/{id}", name="admin.tutorial.delete", methods={"DELETE"})
     * @param Tutorial $tutorial
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Tutorial $tutorial, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $tutorial->getId(), $request->get('_token'))) {
            $this->em->remove($tutorial);
            $this->em->flush();
            $this->addFlash('success', "Tutoriel supprimé");
        } else $this->addFlash('error', "Le tutoriel n'a pas été supprimé !");

        return $this->redirectToRoute('admin.home.index');
    }
}