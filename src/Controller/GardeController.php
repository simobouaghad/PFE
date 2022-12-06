<?php

namespace App\Controller;

use App\Entity\Garde;
use App\Form\GardeType;
use App\Entity\User;
use App\Repository\GardeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CentreRepository;




#[Route('/garde')]
class GardeController extends AbstractController
{
    #[Route('/', name: 'app_garde_index', methods: ['GET'])]
    public function index(GardeRepository $gardeRepository): Response
    {
        return $this->render('garde/index.html.twig', [
            'gardes' => $gardeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_garde_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GardeRepository $gardeRepository, SluggerInterface $slugger, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $garde = new Garde();
        $form = $this->createForm(GardeType::class, $garde);
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
                $garde->setImage($newFilename);
            }

            $user = new User();
            $user->setEmail($garde->getEmail());
            $user->setRoles(['ROLE_GARDE']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $garde->getPassword()
                    )
            );
            $user->setCentre($garde->getCentre());
            $user->setNomuser($garde->getNom() . ' ' . $garde->getPrenom());
            $user->setImage($garde->getImage());

            $userRepository->add($user);


            $gardeRepository->add($garde);
            return $this->redirectToRoute('app_garde_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garde/new.html.twig', [
            'garde' => $garde,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_garde_show', methods: ['GET'])]
    public function show(Garde $garde): Response
    {
        return $this->render('garde/show.html.twig', [
            'garde' => $garde,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_garde_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Garde $garde, GardeRepository $gardeRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(GardeType::class, $garde);
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
                $garde->setImage($newFilename);
            }

            $gardeRepository->add($garde);
            return $this->redirectToRoute('app_garde_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garde/edit.html.twig', [
            'garde' => $garde,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_garde_delete', methods: ['POST'])]
    public function delete(Request $request, Garde $garde, GardeRepository $gardeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garde->getId(), $request->request->get('_token'))) {
            $gardeRepository->remove($garde);
        }

        return $this->redirectToRoute('app_garde_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/centre/in/ville', name: 'garde_centre', methods: ['GET', 'POST'])]
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
