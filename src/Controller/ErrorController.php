<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function index(Request $request): Response
    {
       // $route_name = $request->attributes->get('_route');
        $route= $request->getPathInfo();
        return new Response("La route '$route' n'est pas définie", Response::HTTP_NOT_FOUND);
        // return $this->render('error/index.html.twig', [
        //     'controller_name' => 'ErrorController',
        // ]);
    }
}
