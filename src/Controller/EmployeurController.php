<?php

namespace App\Controller;

use App\Entity\Employeur;
use App\Form\EmployeurType;
use App\Repository\EmployeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\CentreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;





#[Route('/employeur')]
class EmployeurController extends AbstractController
{
    #[Route('/', name: 'app_employeur_index', methods: ['GET'])]
    public function index(EmployeurRepository $employeurRepository): Response
    {
        return $this->render('employeur/index.html.twig', [
            'employeurs' => $employeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeurRepository $employeurRepository, SluggerInterface $slugger): Response
    {
        $employeur = new Employeur();
        $form = $this->createForm(EmployeurType::class, $employeur);
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
                $employeur->setImage($newFilename);
            }

            $employeurRepository->add($employeur);
            return $this->redirectToRoute('app_employeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employeur/new.html.twig', [
            'employeur' => $employeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employeur_show', methods: ['GET'])]
    public function show(Employeur $employeur): Response
    {
        return $this->render('employeur/show.html.twig', [
            'employeur' => $employeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employeur $employeur, EmployeurRepository $employeurRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(EmployeurType::class, $employeur);
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
                $employeur->setImage($newFilename);
            }

            $employeurRepository->add($employeur);
            return $this->redirectToRoute('app_employeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employeur/edit.html.twig', [
            'employeur' => $employeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employeur_delete', methods: ['POST'])]
    public function delete(Request $request, Employeur $employeur, EmployeurRepository $employeurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeur->getId(), $request->request->get('_token'))) {
            $employeurRepository->remove($employeur);
        }

        return $this->redirectToRoute('app_employeur_index', [], Response::HTTP_SEE_OTHER);
    
    
    }

    #[Route('/centre/in/ville', name: 'employeur_ville', methods: ['GET', 'POST'])]
    public function getCentres(Request $request, CentreRepository $centreRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $ville = $request->request->get('ville', 0);
            $Seuils = $centreRepository->findCentres($ville);

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
