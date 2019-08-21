<?php

namespace App\Controller\Admin;

use App\Entity\Informations;
use App\Repository\InformationsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationsController extends AbstractController
{
    private $em;
    /**
     * @var InformationsRepository
     */
    private $informationsRepository;

    public function __construct(ObjectManager $em, InformationsRepository $informationsRepository)
    {
        $this->em = $em;
        $this->informationsRepository = $informationsRepository;
    }

    /**
     * @Route("/admin/contacts", name="admin.contacts.index")
     * @return Response
     */
    public function index() : Response
    {
        $infos_list = $this->informationsRepository->findAll();
        return $this->render('admin/contacts.html.twig', [
            'infos_list' => $infos_list,
            'current_menu' => 'contacts'
        ]);
    }

    /**
     * @Route("/admin/infos/delete/{id}", name="admin.info.delete", methods={"DELETE"})
     * @param Informations $informations
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Informations $informations, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $informations->getId(), $request->get('_token'))) {
            $this->em->remove($informations);
            $this->em->flush();
            $this->addFlash('success', "Demande d'information supprimée");
        } else $this->addFlash('error', "La demande d'information n'a pas été supprimée !");

        return $this->redirectToRoute('admin.contacts.index');
    }

}
