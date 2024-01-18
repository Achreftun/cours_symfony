<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'app_vehicule')]
    public function index(SessionInterface $session, LoggerInterface $logger): Response
    {
        $nom = $session->get('nom');
        $prenom = $session->get('prenom');
        if ($nom != null && !empty($nom)) {
            $logger->info("Utilisateur connecté : $prenom $nom");
        } else {
            $logger->warning("Utilisateur anonyme connecté");
        }
        //  return $this->forward('App\Controller\HomeController::index');
        // $url = $this->generateUrl('app_home2', ["nom" => "Linus"]);
        // return new RedirectResponse($url);
        // return $this->redirectToRoute('app_home2', ["nom" => "Linus"]);
        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'VehiculeController',
        ]);
        // return $this->redirect('https://www.peugeot.fr/');
    }
}
