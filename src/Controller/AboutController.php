<?php

namespace App\Controller;

use App\Entity\Informations;
use App\Form\InformationType;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/about", name="about.index")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request) : Response
    {
        $info = new Informations($this->getUser());
        $form = $this->createForm(InformationType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($info);
            $this->em->flush();
            $this->addFlash('success', "Merci ! Nous vous répondrons prochainement.");
            return $this->redirectToRoute('about.index');
        }

        return $this->render('pages/about.html.twig',[
            'form' => $form->createView(),
            'info' => $info
        ]);
    }
}