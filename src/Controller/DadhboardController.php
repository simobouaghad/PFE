<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Matire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupeRepository;
use App\Repository\EtudiantRepository;
use App\Repository\MatireRepository;
use App\Repository\DirecteurRepository;
use App\Repository\EmployeurRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\GardeRepository;
use App\Repository\CentreRepository;
use App\Repository\ComptableRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\LessonsRepository;
use App\Repository\ListpaymentRepository;
use App\Repository\PlanningRepository;
use App\Repository\SousCategoryRepository;

#[Route('/admin')]

class DadhboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard' , methods: ['GET'])]
    public function index( GroupeRepository $groupeRepository,
                            EtudiantRepository $etudiantRepository,
                            MatireRepository $matireRepository, 
                            DirecteurRepository $directeurRepository,
                            ProfesseurRepository $professeurRepository, 
                            GardeRepository $gardeRepository, 
                            EmployeurRepository $employeurRepository, 
                            CentreRepository $centreRepository, 
                            ComptableRepository $comptableRepository,
                            ListpaymentRepository $listpaymentRepository,
                        ): Response
    {

        $hasAccess1 = $this->isGranted('ROLE_ADMIN');
        $hasAccess2 = $this->isGranted('ROLE_DIRECTEUR');
        $hasAccess3 = $this->isGranted('ROLE_COMPTABLE');
        $hasAccess4 = $this->isGranted('ROLE_PROFESSEUR');
        $hasAccess5 = $this->isGranted('ROLE_ETUDIANT');

        $user = $this->get('security.token_storage')->getToken()->getUser();
        

        if($hasAccess1) 
        {
            return $this->render('dadhboard/index.html.twig', [
                'groupe' => $groupeRepository->findAll(),
                'etudiants' => $etudiantRepository->findAll(),
                'matiers' => $matireRepository->findAll(),
                'directeur' => $directeurRepository->findAll(),
                'professeur' => $professeurRepository->findAll(),
                'employeur' => $employeurRepository->findAll(),
                'garde' => $gardeRepository->findAll(),
                'centre' => $centreRepository->findAll(),
                'comptable' => $comptableRepository->findAll(),
                'listpayments' => $listpaymentRepository->findAll(),
            ]);
        }else if($hasAccess2 or $hasAccess3 or $hasAccess4 or $hasAccess5 ) 
        {

            $centre = $user->getCentre();
            $groupe = $groupeRepository->findGroupeCentre($centre);
            $etudiants = $etudiantRepository->findEtudiantCentre($centre);
            $matiers = $matireRepository->findMatireCentre($centre);
            $professeur = $professeurRepository->findProfesseurCentre($centre);
            $employeur = $employeurRepository->findEmployeurCentre($centre);

            return $this->render('dadhboard/index_dire.html.twig', [
                'groupe' => $groupe,
                'etudiants' => $etudiants,
                'matiers' => $matiers,
                'professeur' => $professeur,
                'employeur' => $employeur,
                'listpayments' => $listpaymentRepository->findAll(),
            ]);
        }
        
    }

    #[Route('/lessons', name: 'app_etudiant_mat', methods: ['GET'])]
    public function matire(GestionmatireRepository $gestionmatireRepository, EtudiantRepository $etudiantRepository, ProfesseurRepository $professeurRepository): Response
    {
        $hasAccess4 = $this->isGranted('ROLE_PROFESSEUR');
        $hasAccess5 = $this->isGranted('ROLE_ETUDIANT');

        if ($hasAccess5) {
            return $this->render('etudiant/lessons.html.twig', [
                'matires' => $gestionmatireRepository->findAll(),
                'etudiants' => $etudiantRepository->findAll(),
            ]);
        }
        if($hasAccess4) {
            return $this->render('etudiant/lessons.html.twig', [
                'matires' => $gestionmatireRepository->findAll(),
                'professeurs' => $professeurRepository->findAll(),
            ]);
        }
    }

    #[Route('/planning', name: 'app_professeur_plan', methods: ['GET'])]
    public function planning(ProfesseurRepository $professeurRepository, PlanningRepository $planningRepository, EtudiantRepository $etudiantRepository): Response
    {
        $hasAccess4 = $this->isGranted('ROLE_PROFESSEUR');
        $hasAccess5 = $this->isGranted('ROLE_ETUDIANT');

        if($hasAccess4) {
            return $this->render('professeur/plan.html.twig', [
                'professeurs' => $professeurRepository->findAll(),
            ]);
        }

        if($hasAccess5) {
            return $this->render('etudiant/planning.html.twig', [
                'plannings' => $planningRepository->findAll(),
                'etudiants' => $etudiantRepository->findAll(),
            ]);
            
        }
    }

    #[Route('/{id}', name: 'app_lessons_cours', methods: ['GET'])]
    public function courses(Matire $matire, LessonsRepository $lessonsRepository): Response
    {

        return $this->render('etudiant/courses.html.twig', [
            'matire' => $matire,
            'lessons' => $lessonsRepository->findAll(),
        ]);
    }

    

}
