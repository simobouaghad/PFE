<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Semestre;
use App\Form\GroupeType;
use App\Repository\GroupeRepository;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SousCategoryRepository;
use App\Repository\CategoryRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\MatireRepository;
use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;




#[Route('/groupe')]
class GroupeController extends AbstractController
{
    #[Route('/', name: 'app_groupe_index', methods: ['GET'])]
    public function index(GroupeRepository $groupeRepository, GestionmatireRepository $gestionmatireRepository, SessionRepository $sessionRepository): Response
    {
        return $this->render('groupe/index.html.twig', [
            'groupes' => $groupeRepository->findAll(),
            'gestionmatires' => $gestionmatireRepository->findAll(),
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/notes', name: 'app_directeur_notes', methods: ['GET'])]
    public function notes(SessionRepository $sessionRepository): Response
    {
        return $this->render('directeur/notes.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/{id}/groupes', name: 'app_groupe_session', methods: ['GET'])]
    public function session(Semestre $semestre, GroupeRepository $groupeRepository, GestionmatireRepository $gestionmatireRepository, SessionRepository $sessionRepository): Response
    {
        return $this->render('groupe/index.html.twig', [
            'groupes' => $groupeRepository->findAll(),
            'semestre' => $semestre,
            'gestionmatires' => $gestionmatireRepository->findAll(),
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_groupe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GroupeRepository $groupeRepository): Response
    {
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeRepository->add($groupe);
            return $this->redirectToRoute('app_groupe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groupe_show', methods: ['GET'])]
    public function show(Groupe $groupe): Response
    {
        return $this->render('groupe/show.html.twig', [
            'groupe' => $groupe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_groupe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Groupe $groupe, GroupeRepository $groupeRepository): Response
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeRepository->add($groupe);
            return $this->redirectToRoute('app_groupe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_groupe_delete', methods: ['POST'])]
    public function delete(Request $request, Groupe $groupe, GroupeRepository $groupeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $groupeRepository->remove($groupe);
        }

        return $this->redirectToRoute('app_groupe_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/etudiant', name: 'app_groupe_etudiant', methods: ['GET'])]
    public function etudiant(Groupe $groupe, EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('groupe/etudiant.html.twig', [
            'groupe' => $groupe,
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    
    #[Route('/{id}/matires', name: 'app_groupe_matires', methods: ['GET'])]
    public function matire(Groupe $groupe, MatireRepository $matireRepository, GestionmatireRepository $gestionmatireRepository): Response
    {
        return $this->render('groupe/matires.html.twig', [
            'groupe' => $groupe,
            'gestion_matires' => $gestionmatireRepository->findAll(),
            'matires' => $matireRepository->findAll(),
        ]);
    }

    #[Route('/category/in/centre', name: 'groupe_category', methods: ['GET', 'POST'])]
    public function getCategory(Request $request, CategoryRepository $categoryRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $centre = $request->request->get('centre', 0);
            $Seuils = $categoryRepository->findCategories($centre);

            $jsonSeuils = [];
            if ($Seuils != null) {
                foreach ($Seuils as $key => $seuil) {
                    $jsonSeuils[$key]['id'] = $seuil->getId();
                    $jsonSeuils[$key]['name'] = $seuil->getName();
                }
            }
            return new JsonResponse($jsonSeuils);
        }
    }

    #[Route('/souscategory/in/category', name: 'groupe_sous_category', methods: ['GET', 'POST'])]
    public function getSousCategory(Request $request, SousCategoryRepository $souscategoryRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $category = $request->request->get('category', 0);
            $Seuils = $souscategoryRepository->findSousCategories($category);

            $jsonSeuils = [];
            if ($Seuils != null) {
                foreach ($Seuils as $key => $seuil) {
                    $jsonSeuils[$key]['id'] = $seuil->getId();
                    $jsonSeuils[$key]['name'] = $seuil->getName();
                }
            }
            return new JsonResponse($jsonSeuils);
        }
    }

}
