<?php

namespace App\Controller;

use App\Entity\Gestionmatire;
use App\Entity\Groupe;
use App\Entity\Semestre;
use App\Form\GestionmatireType;
use App\Repository\EtudiantRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\GroupeRepository;
use App\Repository\ListnoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestionmatire')]
class GestionmatireController extends AbstractController
{
    #[Route('/', name: 'app_gestionmatire_index', methods: ['GET'])]
    public function index(GestionmatireRepository $gestionmatireRepository): Response
    {
        return $this->render('gestionmatire/index.html.twig', [
            'gestionmatires' => $gestionmatireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gestionmatire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GestionmatireRepository $gestionmatireRepository): Response
    {
        $gestionmatire = new Gestionmatire();
        $form = $this->createForm(GestionmatireType::class, $gestionmatire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $gestionmatireRepository->add($gestionmatire);
            return $this->redirectToRoute('app_gestionmatire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gestionmatire/new.html.twig', [
            'gestionmatire' => $gestionmatire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gestionmatire_show', methods: ['GET'])]
    public function show(Gestionmatire $gestionmatire): Response
    {
        return $this->render('gestionmatire/show.html.twig', [
            'gestionmatire' => $gestionmatire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gestionmatire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gestionmatire $gestionmatire, GestionmatireRepository $gestionmatireRepository): Response
    {
        $form = $this->createForm(GestionmatireType::class, $gestionmatire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gestionmatireRepository->add($gestionmatire);
            return $this->redirectToRoute('app_gestionmatire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gestionmatire/edit.html.twig', [
            'gestionmatire' => $gestionmatire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gestionmatire_delete', methods: ['POST'])]
    public function delete(Request $request, Gestionmatire $gestionmatire, GestionmatireRepository $gestionmatireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gestionmatire->getId(), $request->request->get('_token'))) {
            $gestionmatireRepository->remove($gestionmatire);
        }

        return $this->redirectToRoute('app_gestionmatire_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/notes', name: 'app_matire_notes', methods: ['GET'])]
    public function notes(Semestre $semestre, GroupeRepository $groupeRepository, GestionmatireRepository $gestionmatireRepository,  ListnoteRepository $listnoteRepository, EtudiantRepository $etudiantRepository): Response
    {
        $grp = $_GET['grp'];
        $mtr = $_GET['mtr'];

        return $this->render('matire/notes.html.twig', [
            'list_notes' => $listnoteRepository->findAll(),
            'etudiants' => $etudiantRepository->findAll(),
            'gestionmatires' => $gestionmatireRepository->findAll(),
            'groupes' => $groupeRepository->findAll(),
            'semestre' => $semestre,
            'grp' => $grp,
            'mtr'=> $mtr,
        ]);
    }
}
