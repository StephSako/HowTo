<?php

namespace App\Controller\Admin;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumsController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var ForumRepository
     */
    private $fr;

    public function __construct(ForumRepository $fr, ObjectManager $em){
        $this->em = $em;
        $this->fr = $fr;
    }

    /**
     * @Route("/admin/forum/create", name="admin.forum.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request):Response
    {
        $forum = new Forum($this->getUser());
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($forum);
            $this->em->flush();
            return $this->redirectToRoute('admin.home.index');
        }

        return $this->render('pages/new.html.twig', [
            'forum' => $forum,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/forum/edit/{id}", name="admin.forum.edit")
     * @param Forum $forum
     * @param Request $request
     * @return Response
     */
    public function edit(Forum $forum, Request $request) : Response
    {
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Forum modifié avec succès !');
            return $this->redirectToRoute('admin.home.index');
        }

        return $this->render('pages/edit.html.twig', [
            'post' => $forum,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/forum/delete/{id}", name="admin.forum.delete", methods={"DELETE"})
     * @param Forum $forum
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Forum $forum, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $forum->getId(), $request->get('_token'))) {
            $this->em->remove($forum);
            $this->em->flush();
            $this->addFlash('success', "Forum supprimé");
        } else $this->addFlash('error', "Le forum n'a pas été supprimé !");

        return $this->redirectToRoute('admin.home.index');
    }

}