<?php
namespace App\Controller;

use App\Controller\PanelData\Categories;
use App\Entity\Category;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var UserRepository
     */
    private $sr;

    /**
     * @var Category[]|array
     */
    private $categories;

    public function __construct(UserRepository $sr, ObjectManager $em, Categories $categories){
        $this->sr = $sr;
        $this->em = $em;
        $this->categories = $categories->getCategories();
    }

    /**
     * @Route("/connexion", name="connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils) : Response
    {
        if ($this->getUser() == null) {
            $lastusername = $authenticationUtils->getLastUsername();
            $error = $authenticationUtils->getLastAuthenticationError();
            return $this->render('pages/login.twig', [
                'lastusername' => $lastusername,
                'error' => $error,
                'categories' => $this->categories
            ]);
        }
        else return $this->render('redirect/connected.html.twig', [
            'categories' => $this->categories
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder):Response
    {
        if ($this->getUser() == null) {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $password = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $this->em->persist($user);
                $this->em->flush();
                $this->addFlash('success', 'Bienvenue ! Vous vous êtes inscrit !');
                return $this->redirectToRoute('connexion');
            }

            return $this->render('pages/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
                'categories' => $this->categories
            ]);
        }
        else return $this->render('redirect/connected.html.twig');
    }

}