<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Entity\Adresse;
use App\Entity\Etudiant;
use App\Entity\Personne;
use App\Entity\Enseignant;
use App\Form\PersonneType;
use App\Entity\Commentaire;
use App\Service\AdresseEmailService;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    #[Route('/personne/search', name: 'app_personne_search_by')]
    public function searchBy(Request $request, EntityManagerInterface $em): Response
    {
        $nom = $request->get("nom");
        $prenom = $request->get("prenom");
        // $personnes = $em->getRepository(Personne::class)->findBy(
        //     ["nom" => $nom, "prenom" => $prenom]
        // );
        $personnes = $em->getRepository(Personne::class)->findByNomAndPrenom($nom, $prenom);
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes
        ]);
    }
    #[Route('/personne/show/{nom}', name: 'app_personne_show_by')]
    public function showBy(string $nom, PersonneRepository $personneRepository): Response
    {
        // $personnes = $personneRepository->findBy(
        //     ["nom" => $nom]
        // );
        $personnes = $personneRepository->findByNom($nom);
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes
        ]);
    }
    #[Route('/personne/show', name: 'app_personne_show')]
    public function show(PersonneRepository $personneRepository): Response
    {
        $personnes = $personneRepository->findAll();
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes
        ]);
    }
    // injection de dépendance
    #[Route('/personne/delete/{id}', name: 'app_personne_delete')]
    public function delete(Personne $personne, EntityManagerInterface $em): Response
    {
        // $personne = $em->getRepository(Personne::class)->find($id);
        // if (!$personne) {
        //     throw $this->createNotFoundException("Personne avec l'identifiant $id n'existe pas");
        // }
        $em->remove($personne);
        $em->flush();
        return $this->redirectToRoute("app_personne_show");

    }
    #[Route('/personne/add', name: 'app_personne_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('app_personne_show');
        }
        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form,
        ]);
    }
    #[Route('/personne/edit/{id}', name: 'app_personne_edit')]
    public function edit(Personne $personne, Request $request, EntityManagerInterface $em): Response
    {
        // $id = $request->get('id');
        // $personne = $em->getRepository(Personne::class)->find($id);
        // if (!$personne) {
        //     throw $this->createNotFoundException("Personne avec l'identifiant $id n'existe pas");
        // }
        $form = $this->createForm(PersonneType::class, $personne)->remove('adresse');

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $personne = $form->getData();
            $em->flush();
            return $this->redirectToRoute('app_personne_show');
        }
        return $this->render('personne/edit.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form,
        ]);
    }
    // injection de dépendance
    #[Route('/personne/add/{nom}/{prenom}', name: 'app_personne_add')]
    public function index(string $nom, string $prenom, AdresseEmailService $adresseEmailService, SessionInterface $session, EntityManagerInterface $em): Response
    {
        $session->set('prenom', $prenom);
        $session->set('nom', $nom);
        $personne = new Personne();
        $personne->setNom($nom);
        $personne->setPrenom($prenom);
        $etudiant = new Etudiant();
        $etudiant->setNom('Maggio');
        $etudiant->setPrenom('Carol');
        $etudiant->setNiveau('master');
        $enseignant = new Enseignant();
        $enseignant->setNom('Baggio');
        $enseignant->setPrenom('Roberto');
        $enseignant->setSalaire(2000);
        $em->persist($personne);
        $em->persist($etudiant);
        $em->persist($enseignant);
        $em->flush();
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'email' => $adresseEmailService->generateEmailFromNomAndPrenom($nom, $prenom),
        ]);
    }
    #[Route('/personne/edit/{id}/{nom}/{prenom}', name: 'app_personne_update')]
    public function update(int $id, string $nom, string $prenom, EntityManagerInterface $em): Response
    {
        $personne = $em->getRepository(Personne::class)->find($id);
        if (!$personne) {
            throw $this->createNotFoundException("Personne avec l'identifiant $id n'existe pas");
        }
        $personne->setNom($nom);
        $personne->setPrenom($prenom);
        $em->flush();
        return $this->redirectToRoute("app_personne_show");
    }
}
