<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Exams;
use App\Entity\SousCategory;
use App\Form\ExamsType;
use App\Repository\CategoryRepository;
use App\Repository\EtudiantRepository;
use App\Repository\ExamsRepository;
use App\Repository\SousCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/exams')]
class ExamsController extends AbstractController
{
    #[Route('/', name: 'app_exams_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('exams/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_exams_new', methods: ['GET', 'POST'])]
    public function new(Request $request, 
        ExamsRepository $examsRepository ,
        SluggerInterface $slugger
    ): Response
    {
        $exam = new Exams();
        $form = $this->createForm(ExamsType::class, $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('examplan')->getData();

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
                        $this->getParameter('brochures_directory_file'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $exam->setExamplan($newFilename);
            }


            $examsRepository->add($exam);
            return $this->redirectToRoute('app_exams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exams/new.html.twig', [
            'exam' => $exam,
            'form' => $form,
        ]);
    }

    #[Route('/examplan', name: 'app_planning_examplan', methods: ['GET'])]
    public function examplan(ExamsRepository $examsRepository, EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/examplan.html.twig', [
            'exams' => $examsRepository->findAll(),
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'get_app_sousCategories', methods: ['GET'])]
    public function sousCat(Category $category, SousCategoryRepository $sousCategoryRepository): Response
    {   

        return $this->render('exams/sousCate.html.twig', [
            'category' => $category,
            'sousCategories' => $sousCategoryRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exams_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exams $exam,
        ExamsRepository $examsRepository,
        SluggerInterface $slugger
    ): Response
    {
        $form = $this->createForm(ExamsType::class, $exam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('examplan')->getData();

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
                        $this->getParameter('brochures_directory_file'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $exam->setExamplan($newFilename);
            }

            $examsRepository->add($exam);
            return $this->redirectToRoute('app_exams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exams/edit.html.twig', [
            'exam' => $exam,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exams_delete', methods: ['POST'])]
    public function delete(Request $request, Exams $exam, ExamsRepository $examsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exam->getId(), $request->request->get('_token'))) {
            $examsRepository->remove($exam);
        }

        return $this->redirectToRoute('app_exams_index', [], Response::HTTP_SEE_OTHER);
    }


    

}
