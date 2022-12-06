<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\User;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;




#[Route('/professeur')]
class ProfesseurController extends AbstractController
{
    #[Route('/', name: 'app_professeur_index', methods: ['GET'])]
    public function index(ProfesseurRepository $professeurRepository, UserRepository $userRepository): Response
    {
        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProfesseurRepository $professeurRepository, SluggerInterface $slugger, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Image

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
                $professeur->setImage($newFilename);
            }

            // planning

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('planning')->getData();

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
                $professeur->setPlanning($newFilename);
            }

            $user = new User();
            $user->setEmail($professeur->getEmail());
            $user->setRoles(['ROLE_PROFESSEUR']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $professeur->getPassword()
                    )
            );
            $user->setCentre($professeur->getCentre());
            $user->setNomuser(ucfirst($professeur->getNom()) . ' ' . strtoupper($professeur->getPrenom()));
            $user->setImage($professeur->getImage());

            $userRepository->add($user);


            $professeurRepository->add($professeur);
            return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_show', methods: ['GET'])]
    public function show(Professeur $professeur): Response
    {
        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeur $professeur, ProfesseurRepository $professeurRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProfesseurType::class, $professeur);
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
                $professeur->setImage($newFilename);
            }

            // planning

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('planning')->getData();

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
                $professeur->setPlanning($newFilename);
            }


            $professeurRepository->add($professeur);
            return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_delete', methods: ['POST'])]
    public function delete(Request $request, Professeur $professeur, ProfesseurRepository $professeurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
            $professeurRepository->remove($professeur);
        }

        return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/professeur/in/centre', name: 'professeur_centre', methods: ['GET', 'POST'])]
    public function getProfesseur(Request $request, ProfesseurRepository $professeurRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $centre = $request->request->get('centre', 0);
            $Seuils = $professeurRepository->findProfesseurCentre($centre);

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
