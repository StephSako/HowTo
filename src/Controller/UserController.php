<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var UserRepository
     */
    private $sr;

    public function __construct(UserRepository $sr, ObjectManager $em){
        $this->sr = $sr;
        $this->em = $em;
    }

    /**
     * @Route("/account/user/edit", name="user.account.edit")
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $encoder) : Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->em->flush();
            $this->addFlash('success', 'Votre compte a été modifié avec succès !');
            return $this->redirectToRoute('tutorials.showTutorials');
        }

        return $this->render('pages/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}