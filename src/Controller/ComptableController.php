<?php

namespace App\Controller;

use App\Entity\Comptable;
use App\Form\ComptableType;
use App\Entity\User;
use App\Repository\ComptableRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CentreRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;





#[Route('/comptable')]
class ComptableController extends AbstractController
{
    #[Route('/', name: 'app_comptable_index', methods: ['GET'])]
    public function index(ComptableRepository $comptableRepository): Response
    {
        return $this->render('comptable/index.html.twig', [
            'comptables' => $comptableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_comptable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ComptableRepository $comptableRepository, UserRepository $userRepository, SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $comptable = new Comptable();
        $form = $this->createForm(ComptableType::class, $comptable);
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
                $comptable->setImage($newFilename);
            }

            $user = new User();
            $user->setEmail($comptable->getEmail());
            $user->setRoles(['ROLE_COMPTABLE']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $comptable->getPassword()
                    )
            );
            $user->setVille($comptable->getVille());
            $user->setCentre($comptable->getCentre());
            $user->setNomuser($comptable->getNom() . ' ' . $comptable->getPrenom());
            $user->setImage($comptable->getImage());

            $userRepository->add($user);

            $comptableRepository->add($comptable);
            return $this->redirectToRoute('app_comptable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comptable/new.html.twig', [
            'comptable' => $comptable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comptable_show', methods: ['GET'])]
    public function show(Comptable $comptable): Response
    {
        return $this->render('comptable/show.html.twig', [
            'comptable' => $comptable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comptable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comptable $comptable, ComptableRepository $comptableRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ComptableType::class, $comptable);
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
                $comptable->setImage($newFilename);
            }

            $comptableRepository->add($comptable);
            return $this->redirectToRoute('app_comptable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comptable/edit.html.twig', [
            'comptable' => $comptable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comptable_delete', methods: ['POST'])]
    public function delete(Request $request, Comptable $comptable, ComptableRepository $comptableRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comptable->getId(), $request->request->get('_token'))) {
            $comptableRepository->remove($comptable);
        }

        return $this->redirectToRoute('app_comptable_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/centre/in/ville', name: 'comptable_centre', methods: ['GET', 'POST'])]
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
