<?php

namespace App\Controller;

use App\Entity\Directeur;
use App\Entity\Semestre;
use App\Entity\User;
use App\Form\DirecteurType;
use App\Repository\DirecteurRepository;
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
use App\Repository\CentreRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\GroupeRepository;
use App\Repository\SessionRepository;

#[Route('/directeur')]
class DirecteurController extends AbstractController
{
    #[Route('/', name: 'app_directeur_index', methods: ['GET'])]
    public function index(DirecteurRepository $directeurRepository): Response
    {
        return $this->render('directeur/index.html.twig', [
            'directeurs' => $directeurRepository->findAll(),
        ]);
    }

    #[Route('/{id}/groupes', name: 'app_groupe_notes', methods: ['GET'])]
    public function notes(Semestre $semestre, GroupeRepository $groupeRepository, GestionmatireRepository $gestionmatireRepository, SessionRepository $sessionRepository): Response
    {
        return $this->render('directeur/sessionnotes.html.twig', [
            'groupes' => $groupeRepository->findAll(),
            'semestre' => $semestre,
            'gestionmatires' => $gestionmatireRepository->findAll(),
            'sessions' => $sessionRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_directeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DirecteurRepository $directeurRepository, SluggerInterface $slugger, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $directeur = new Directeur();
        $form = $this->createForm(DirecteurType::class, $directeur);
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
                $directeur->setImage($newFilename);
            }

            $user = new User();
            $user->setEmail($directeur->getEmail());
            $user->setRoles(['ROLE_DIRECTEUR']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $directeur->getPassword()
                    )
            );
            $user->setVille($directeur->getVille());
            $user->setCentre($directeur->getCentre());
            $user->setNomuser($directeur->getNom() . ' ' . $directeur->getPrenom());
            $user->setImage($directeur->getImage());

            $userRepository->add($user);

            $directeurRepository->add($directeur);
            return $this->redirectToRoute('app_directeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('directeur/new.html.twig', [
            'directeur' => $directeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_directeur_show', methods: ['GET'])]
    public function show(Directeur $directeur): Response
    {
        return $this->render('directeur/show.html.twig', [
            'directeur' => $directeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_directeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Directeur $directeur, DirecteurRepository $directeurRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(DirecteurType::class, $directeur);
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
                $directeur->setImage($newFilename);
            }
            
            $directeurRepository->add($directeur);
            return $this->redirectToRoute('app_directeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('directeur/edit.html.twig', [
            'directeur' => $directeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_directeur_delete', methods: ['POST'])]
    public function delete(Request $request, Directeur $directeur, DirecteurRepository $directeurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$directeur->getId(), $request->request->get('_token'))) {
            $directeurRepository->remove($directeur);
        }

        return $this->redirectToRoute('app_directeur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/centre/in/ville', name: 'directeur_centre', methods: ['GET', 'POST'])]
    public function getCentres(Request $request, CentreRepository $centreRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $centre = $request->request->get('ville', 0);
            $Seuils = $centreRepository->findCentres($centre);

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
