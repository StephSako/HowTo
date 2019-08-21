<?php

namespace App\Controller\Admin;

use App\Entity\ForumReporting;
use App\Entity\TutorialReporting;
use App\Repository\ForumReportingRepository;
use App\Repository\TutorialReportingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportingController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var ForumReportingRepository
     */
    private $forumReportingRepository;
    /**
     * @var TutorialReportingRepository
     */
    private $tutorialReportingRepository;

    public function __construct(ForumReportingRepository $forumReportingRepository, ObjectManager $em, TutorialReportingRepository $tutorialReportingRepository){
        $this->forumReportingRepository = $forumReportingRepository;
        $this->em = $em;
        $this->tutorialReportingRepository = $tutorialReportingRepository;
    }

    /**
     * @Route("/admin/reports", name="admin.reports.index")
     * @return Response
     */
    public function index() : Response
    {
        $forumreports = $this->forumReportingRepository->findALl();
        $tutorialreports = $this->tutorialReportingRepository->findALl();
        return $this->render('admin/reports.html.twig', [
            'forumreports' => $forumreports,
            'tutorialreports' => $tutorialreports,
            'current_menu' => 'signalements'
        ]);
    }

    /**
     * @Route("/forum/report/delete/{id}", name="forum.report.deleteFR", methods={"DELETE"})
     * @param ForumReporting $forumReporting
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteFR(ForumReporting $forumReporting, Request $request){
        if ($this->isCsrfTokenValid('delete' . $forumReporting->getId(), $request->get('_token'))){
            $this->em->remove($forumReporting);
            $this->em->flush();
            $this->addFlash('success', 'Signalement supprimé');
        }
        else $this->addFlash('error', "Le signalement n'a pas été supprimé !");

        return $this->redirectToRoute('admin.reports.index');
    }

    /**
     * @Route("/tutorial/report/delete/{id}", name="tutorial.report.deleteTR", methods={"DELETE"})
     * @param TutorialReporting $tutorialReporting
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteTR(TutorialReporting $tutorialReporting, Request $request){
        if ($this->isCsrfTokenValid('delete' . $tutorialReporting->getId(), $request->get('_token'))){
            $this->em->remove($tutorialReporting);
            $this->em->flush();
            $this->addFlash('success', 'Signalement supprimé');
        }
        else $this->addFlash('error', "Le signalement n'a pas été supprimé !");

        return $this->redirectToRoute('admin.reports.index');
    }
}