<?php

namespace App\Controller;

use App\Entity\Listpayment;
use App\Repository\EtudiantRepository;
use App\Form\ListpaymentType;
use App\Repository\ListpaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/listpayment')]
class ListpaymentController extends AbstractController
{
    #[Route('/', name: 'app_listpayment_index', methods: ['GET'])]
    public function index(ListpaymentRepository $listpaymentRepository): Response
    {
        return $this->render('listpayment/index.html.twig', [
            'listpayments' => $listpaymentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_listpayment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListpaymentRepository $listpaymentRepository): Response
    {
        $listpayment = new Listpayment();
        $form = $this->createForm(ListpaymentType::class, $listpayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listpaymentRepository->add($listpayment);
            return $this->redirectToRoute('app_listpayment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listpayment/new.html.twig', [
            'listpayment' => $listpayment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_listpayment_show', methods: ['GET'])]
    public function show(Listpayment $listpayment, EtudiantRepository $etudiantRepository): Response
    {
        $cne = $listpayment->getCne();
        $etudiant = $etudiantRepository->findEtudiantCne($cne);

        return $this->render('listpayment/show.html.twig', [
            'listpayment' => $listpayment,
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_listpayment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Listpayment $listpayment, ListpaymentRepository $listpaymentRepository): Response
    {
        $form = $this->createForm(ListpaymentType::class, $listpayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listpaymentRepository->add($listpayment);
            return $this->redirectToRoute('app_listpayment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listpayment/edit.html.twig', [
            'listpayment' => $listpayment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_listpayment_delete', methods: ['POST'])]
    public function delete(Request $request, Listpayment $listpayment, ListpaymentRepository $listpaymentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listpayment->getId(), $request->request->get('_token'))) {
            $listpaymentRepository->remove($listpayment);
        }

        return $this->redirectToRoute('app_listpayment_index', [], Response::HTTP_SEE_OTHER);
    }
}
