<?php

namespace App\Controller;

use App\Entity\Listnote;
use App\Form\ListnoteType;
use App\Repository\EtudiantRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\ListnoteRepository;
use App\Repository\SemestreRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/listnote')]
class ListnoteController extends AbstractController
{
    #[Route('/', name: 'app_listnote_index', methods: ['GET'])]
    public function index(ListnoteRepository $listnoteRepository, EtudiantRepository $etudiantRepository, GestionmatireRepository $gestionmatireRepository): Response
    {
        return $this->render('listnote/index.html.twig', [
            'listnotes' => $listnoteRepository->findAll(),
            'etudiants' => $etudiantRepository->findAll(),
            'gestionmatires' => $gestionmatireRepository->findAll(),
        ]);
    }
    
    #[Route('/new', name: 'app_listnote_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListnoteRepository $listnoteRepository): Response
    {
        $listnote = new Listnote();
        $form = $this->createForm(ListnoteType::class, $listnote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listnoteRepository->add($listnote);
            return $this->redirectToRoute('app_listnote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listnote/new.html.twig', [
            'listnote' => $listnote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_listnote_show', methods: ['GET'])]
    public function show(Listnote $listnote): Response
    {
        return $this->render('listnote/show.html.twig', [
            'listnote' => $listnote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_listnote_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Listnote $listnote, ListnoteRepository $listnoteRepository, EtudiantRepository $etudiantRepository): Response
    {
        $form = $this->createForm(ListnoteType::class, $listnote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listnoteRepository->add($listnote);
            return $this->redirectToRoute('app_listnote_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listnote/edit.html.twig', [
            'listnote' => $listnote,
            'form' => $form,
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_listnote_delete', methods: ['POST'])]
    public function delete(Request $request, Listnote $listnote, ListnoteRepository $listnoteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listnote->getId(), $request->request->get('_token'))) {
            $listnoteRepository->remove($listnote);
        }

        return $this->redirectToRoute('app_listnote_index', [], Response::HTTP_SEE_OTHER);
    }

}
