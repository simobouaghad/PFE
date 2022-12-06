<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\SousCategory;
use App\Repository\GroupeRepository;
use App\Form\SousCategoryType;
use App\Repository\SousCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CategoryRepository;
use App\Repository\ExamsRepository;

#[Route('/sous/category')]
class SousCategoryController extends AbstractController
{
    #[Route('/', name: 'app_sous_category_index', methods: ['GET'])]
    public function index(SousCategoryRepository $sousCategoryRepository): Response
    {
        return $this->render('sous_category/index.html.twig', [
            'sous_categories' => $sousCategoryRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'get_app_examplan', methods: ['GET'])]
    public function examplan(SousCategory $sousCategorie, ExamsRepository $examsRepository): Response
    {

        return $this->render('sous_category/examplan.html.twig', [
            'sousCategorie' => $sousCategorie,
            'exams' => $examsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sous_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SousCategoryRepository $sousCategoryRepository): Response
    {
        $sousCategory = new SousCategory();
        $form = $this->createForm(SousCategoryType::class, $sousCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousCategoryRepository->add($sousCategory);
            return $this->redirectToRoute('app_sous_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sous_category/new.html.twig', [
            'sous_category' => $sousCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sous_category_show', methods: ['GET'])]
    public function show(SousCategory $sousCategory): Response
    {
        return $this->render('sous_category/show.html.twig', [
            'sous_category' => $sousCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sous_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SousCategory $sousCategory, SousCategoryRepository $sousCategoryRepository): Response
    {
        $form = $this->createForm(SousCategoryType::class, $sousCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousCategoryRepository->add($sousCategory);
            return $this->redirectToRoute('app_sous_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sous_category/edit.html.twig', [
            'sous_category' => $sousCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sous_category_delete', methods: ['POST'])]
    public function delete(Request $request, SousCategory $sousCategory, SousCategoryRepository $sousCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousCategory->getId(), $request->request->get('_token'))) {
            $sousCategoryRepository->remove($sousCategory);
        }

        return $this->redirectToRoute('app_sous_category_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/groupe', name: 'app_sous_category_groupe', methods: ['GET'])]
    public function groupes(SousCategory $sousCategory, GroupeRepository $groupeRepository): Response
    {
        return $this->render('sous_category/groupes.html.twig', [
            'sousCategory' => $sousCategory,
            'groupes' => $groupeRepository->findAll(),
        ]);
    }

    #[Route('/category/in/centre', name: 'etudiant_category', methods: ['GET', 'POST'])]
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

    

}
