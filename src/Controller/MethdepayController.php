<?php

namespace App\Controller;

use App\Entity\Methdepay;
use App\Form\MethdepayType;
use App\Repository\MethdepayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/methdepay')]
class MethdepayController extends AbstractController
{
    #[Route('/', name: 'app_methdepay_index', methods: ['GET'])]
    public function index(MethdepayRepository $methdepayRepository): Response
    {
        return $this->render('methdepay/index.html.twig', [
            'methdepays' => $methdepayRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_methdepay_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MethdepayRepository $methdepayRepository): Response
    {
        $methdepay = new Methdepay();
        $form = $this->createForm(MethdepayType::class, $methdepay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $methdepayRepository->add($methdepay);
            return $this->redirectToRoute('app_methdepay_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('methdepay/new.html.twig', [
            'methdepay' => $methdepay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_methdepay_show', methods: ['GET'])]
    public function show(Methdepay $methdepay): Response
    {
        return $this->render('methdepay/show.html.twig', [
            'methdepay' => $methdepay,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_methdepay_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Methdepay $methdepay, MethdepayRepository $methdepayRepository): Response
    {
        $form = $this->createForm(MethdepayType::class, $methdepay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $methdepayRepository->add($methdepay);
            return $this->redirectToRoute('app_methdepay_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('methdepay/edit.html.twig', [
            'methdepay' => $methdepay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_methdepay_delete', methods: ['POST'])]
    public function delete(Request $request, Methdepay $methdepay, MethdepayRepository $methdepayRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$methdepay->getId(), $request->request->get('_token'))) {
            $methdepayRepository->remove($methdepay);
        }

        return $this->redirectToRoute('app_methdepay_index', [], Response::HTTP_SEE_OTHER);
    }
}
