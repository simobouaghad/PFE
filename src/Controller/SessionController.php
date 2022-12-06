<?php

namespace App\Controller;
use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\EtudiantRepository;
use App\Repository\SemestreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;




#[Route('/session')]
class SessionController extends AbstractController
{

    #[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SessionRepository $sessionRepository): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->add($session);
            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/new.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->add($session);
            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $sessionRepository->remove($session);
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/etudiant', name: 'app_session_etudiant', methods: ['GET'])]
    public function etudiant(Session $session, EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('session/etudiant.html.twig', [
            'session' => $session,
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }


    #[Route('/semestre/in/session', name: 'etudiant_semestre', methods: ['GET', 'POST'])]
    public function getSemestres(Request $request, SemestreRepository $semestreRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $session = $request->request->get('session', 0);
            $Seuils = $semestreRepository->findSemestres($session);

            $jsonSeuils = [];
            if ($Seuils != null) {
                foreach ($Seuils as $key => $seuil) {
                    $jsonSeuils[$key]['id'] = $seuil->getId();
                    $jsonSeuils[$key]['name'] = $seuil->getNom();
                }
            }
            return new JsonResponse($jsonSeuils);
        }
    }


}
