<?php

namespace App\Controller;

use App\Entity\Alien;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    // action : méthode définie dans un contrôleur
    #[Route('/')]
    #[Route('/home', name: 'app_home', methods: ['GET', 'POST'])]
    #[Route('/accueil', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        // $methode = $request->getMethod();
        $route = $request->attributes->get('_route');

        if ($route == 'app_accueil') {
            $nom = $request->get('nom');
            $prenom = $request->get('prenom');
            return $this->render('home/index.html.twig', [
                'controller_name' => "$prenom $nom",
            ]);
        }
        $alien = new Alien();
        $alien->setId(1);
        $alien->setName("Doe");
        $alien->setColor("white");
        $msg = $this->getParameter("msg");
        return $this->render('home/index.html.twig', [
            'controller_name' => $msg,
            'numbers' => [2, 3, 8, 5, 1],
            'alien'=> $alien,
        ]);
    }
    #[Route('/hello/{nom?}', name: 'app_hello3')]
    public function hello3(?string $nom): Response
    {
        if (!isset($nom)) {
            throw new HttpException(404, "Aucune donnée disponible à l'affichage");
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => $nom,
        ]);
    }
    #[Route('/home/{nom}', name: 'app_home2')]
    public function index2(Request $request): Response
    {

        $nom = $request->get('nom');
        return $this->render('home/index.html.twig', [
            'controller_name' => $nom,
        ]);
    }
    #[Route('/hello/{nom}/{age<\d{1,3}>}', name: 'app_hello')]
    public function hello(string $nom, int $age = 0): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => "$nom, $age",
        ]);
    }
    #[Route('/hello/hello/{age<\d{1,3}>}', name: 'app_hello2', priority: 2)]
    public function hello2(int $age = 0): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => "$age",
        ]);
    }
    // #[Route('/hello/{nom}/{age}', name: 'app_hello', requirements: ["age" => "\d{1,3}"])]
    // public function hello(string $nom, int $age): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => "$nom, $age",
    //     ]);
    // }
}
