<?php

namespace App\Controller;

use App\Entity\Matire;
use App\Form\MatireType;
use App\Repository\MatireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\CategoryRepository;
use App\Repository\EtudiantRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\ListnoteRepository;
use App\Repository\SousCategoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;





#[Route('/matire')]
class MatireController extends AbstractController
{
    #[Route('/', name: 'app_matire_index', methods: ['GET'])]
    public function index(MatireRepository $matireRepository): Response
    {
        return $this->render('matire/index.html.twig', [
            'matires' => $matireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_matire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MatireRepository $matireRepository, SluggerInterface $slugger): Response
    {
        $matire = new Matire();
        $form = $this->createForm(MatireType::class, $matire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $matire->setImage($newFilename);
            }

            $matireRepository->add($matire);
            return $this->redirectToRoute('app_matire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('matire/new.html.twig', [
            'matire' => $matire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_matire_show', methods: ['GET'])]
    public function show(Matire $matire): Response
    {
        return $this->render('matire/show.html.twig', [
            'matire' => $matire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_matire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Matire $matire, MatireRepository $matireRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MatireType::class, $matire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $matire->setImage($newFilename);
            }

            $matireRepository->add($matire);
            return $this->redirectToRoute('app_matire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('matire/edit.html.twig', [
            'matire' => $matire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_matire_delete', methods: ['POST'])]
    public function delete(Request $request, Matire $matire, MatireRepository $matireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matire->getId(), $request->request->get('_token'))) {
            $matireRepository->remove($matire);
        }

        return $this->redirectToRoute('app_matire_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/category/in/centre', name: 'matire_centre', methods: ['GET', 'POST'])]
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

    #[Route('/souscategory/in/category', name: 'matire_category', methods: ['GET', 'POST'])]
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

    #[Route('/matire/in/souscategory', name: 'gestionmatire_sousCategory_matire', methods: ['GET', 'POST'])]
    public function getMatire(Request $request, MatireRepository $matireRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $souscategory = $request->request->get('souscategory', 0);
            $Seuils = $matireRepository->findMatireSousCat($souscategory);

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
