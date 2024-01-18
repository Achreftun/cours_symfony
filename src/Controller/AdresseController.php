<?php

namespace App\Controller;

use App\Entity\Adresse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdresseController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/adresse', name: 'app_adresse')]
    #[Route('/adresse/show', name: 'app_adresse_show')]
    public function show(): Response
    {
        $adresses = $this->em->getRepository(Adresse::class)->findAll();
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'adresses' => $adresses
        ]);
    }
    #[Route('/adresse/search', name: 'app_adresse_search')]
    public function search(Request $request): Response
    {
        $value = $request->get('value');
        $adresses = $this->em->getRepository(Adresse::class)->findByValue($value);
       // dd($adresses);
        return $this->render('adresse/index.html.twig', [
            'controller_name' => 'AdresseController',
            'adresses' => $adresses
        ]);
    }
    #[Route('/adresse/delete/{id}', name: 'app_adresse_delete')]
    public function delete(int $id): Response
    {
        $adresse = $this->em->getRepository(Adresse::class)->find($id);
        if (!$adresse) {
            throw $this->createNotFoundException("Adresse avec l'identifiant $id n'existe pas");
        }
        $this->em->remove($adresse);
        $this->em->flush();
        return $this->redirectToRoute('app_adresse_show');
    }

    #[Route('/adresse/add/{rue}/{codePostal}/{ville}', name: 'app_adresse_add')]
    public function new(string $rue, string $codePostal, string $ville): Response
    {
        $adresse = new Adresse();
        $adresse->setCodePostal($codePostal)->setRue($rue)->setVille($ville);
        $this->em->persist($adresse);
        $this->em->flush();
        return $this->redirectToRoute('app_adresse_show');
    }
}
