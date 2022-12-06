<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Listnote;
use App\Entity\Listpayment;
use App\Entity\Session;
use App\Entity\User;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Repository\UserRepository;
use App\Repository\ListpaymentRepository;
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
use App\Repository\CategoryRepository;
use App\Repository\GestionmatireRepository;
use App\Repository\SousCategoryRepository;
use App\Repository\GroupeRepository;
use App\Repository\ListnoteRepository;
use App\Repository\MatireRepository;
use App\Repository\SessionRepository;

#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/bulletins', name: 'app_session_bulletins', methods: ['GET'])]
    public function session_bull(SessionRepository $sessionRepository): Response
    {
        return $this->render('etudiant/session_bulletins.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request,
        EtudiantRepository $etudiantRepository,
        SluggerInterface $slugger,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        ListpaymentRepository $listpaymentRepository,
        MatireRepository $matireRepository,
        ListnoteRepository $listnoteRepository,
    ): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
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
                $etudiant->setImage($newFilename);
            }

            // add etudiant to user table
            $user = new User();
            $user->setEmail($etudiant->getEmail());
            $user->setRoles(['ROLE_ETUDIANT']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $etudiant->getPassword()
                    )
            );
            $user->setCentre($etudiant->getCentre());
            $user->setNomuser(ucfirst($etudiant->getNom()) . ' ' . strtoupper($etudiant->getPrenom()));
            $user->setImage($etudiant->getImage());
            $user->setCne($etudiant->getCne());
            $userRepository->add($user);

            // association bettwen etudiant and Listpay
            if($etudiant->getMethdepay() == 'chaque année') {
                $listpay = new Listpayment();
                $listpay->setName('année');
                $today = date("d-m-Y");
                $listpay->setFrom($today);
                $listpay->setTo(date('d-m-Y', strtotime($today. ' +1 month')));
                $listpay->setPrix($etudiant->getPayement()->getPrix());
                $listpay->setStatus('non payée');
                $listpay->setCne($etudiant->getCne());
                $listpay->setMethodepay($etudiant->getMethdepay());

                $listpaymentRepository->add($listpay);
            }
            else if($etudiant->getMethdepay() == 'chaque 3 mois') {
                $today = date("d-m-Y");
                $j = 3;
                for($i=1; $i<=3; $i++) {
                    $listpay = new Listpayment();
                    $listpay->setName(($j) . ' mois');
                    $listpay->setFrom($today);
                    $listpay->setTo(date('d-m-Y', strtotime($today. ' +3 month')));
                    $listpay->setPrix(($etudiant->getPayement()->getPrix())/3);
                    $listpay->setStatus('non payée');
                    $listpay->setCne($etudiant->getCne());
                    $listpay->setMethodepay($etudiant->getMethdepay());

                    $listpaymentRepository->add($listpay);
                    $today = date('d-m-Y', strtotime($today. ' +3 month'));
                    $j = $j + 3;
                }
            }else {
                $today = date("d-m-Y");
                $j = 1;
                for($i=1; $i<=7; $i++) {
                    $listpay = new Listpayment();
                    $listpay->setName('mois ' . ($j));
                    $listpay->setFrom($today);
                    $listpay->setTo(date('d-m-Y', strtotime($today. ' +1 month')));
                    $listpay->setPrix(($etudiant->getPayement()->getPrix())/7);
                    $listpay->setStatus('non payée');
                    $listpay->setCne($etudiant->getCne());
                    $listpay->setMethodepay($etudiant->getMethdepay());

                    $listpaymentRepository->add($listpay);
                    $today = date('d-m-Y', strtotime($today. ' +1 month'));
                    $j++;
                }
            }
            
            // ajouter l'étudiant dans les listes des notes
            $sousCategory = $etudiant->getSousCategory();
            $matires = $matireRepository->findMatireSousCat($sousCategory);


            if (is_array($matires) || is_object($matires))
            {
                foreach($matires as $matire) {
                    for($i=1; $i<=2; $i++) {
                        $listnote = new Listnote();
                        $listnote->setGroupe($etudiant->getGroupe());
                        $listnote->setMatire($matire);
                        $listnote->setCne($etudiant->getCne());
                        $listnote->setSession($etudiant->getAnnee());
                        $listnote->setSemestre('Semestre ' . $i);
                        $listnoteRepository->add($listnote);
                    }
                }
            }


            $etudiantRepository->add($etudiant);
            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EtudiantRepository $etudiantRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
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
                $etudiant->setImage($newFilename);
            }
            
            $etudiantRepository->add($etudiant);
            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EtudiantRepository $etudiantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $etudiantRepository->remove($etudiant);
        }

        return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/listpayment', name: 'app_etudiant_payment', methods: ['GET'])]
    public function payment(Etudiant $etudiant, ListpaymentRepository $listpaymentRepository)
    {
        $cne = $etudiant->getCne();
        $payments = $listpaymentRepository->findListPayment($cne);

        return $this->render('etudiant/payment.html.twig', [
            'payments' => $payments,
            'etudiant' =>$etudiant,
        ]);
    }


    #[Route('/{id}/notes', name: 'app_etudiant_notes', methods: ['GET'])]
    public function notes(Session $session, ListnoteRepository $listnoteRepository, GestionmatireRepository $gestionmatireRepository, EtudiantRepository $etudiantRepository)
    {
        return $this->render('etudiant/notes.html.twig', [
            'session' => $session,
            'etudiants' => $etudiantRepository->findAll(),
            'list_notes' => $listnoteRepository->findAll(),
            'gestionmatires' => $gestionmatireRepository->findAll(),
        ]);
    }

    

    

    // get functions //

    #[Route('/centre/in/ville', name: 'etudiant_centre', methods: ['GET', 'POST'])]
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

    #[Route('/souscategory/in/category', name: 'etudiant_sous_category', methods: ['GET', 'POST'])]
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

    #[Route('/groupe/in/souscategory', name: 'etudiant_groupe', methods: ['GET', 'POST'])]
    public function getGroupes(Request $request, GroupeRepository $groupeRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $souscategory = $request->request->get('souscategory', 0);
            $Seuils = $groupeRepository->findGroupe($souscategory);

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
