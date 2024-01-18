<?php

namespace App\Controller;

use App\Service\CalculService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalculController extends AbstractController
{
    #[Route('/calcul/{op}', name: 'app_calcul')]
    public function index(Request $request, CalculService $calculService): Response
    {
        $op = $request->get('op');
        $var1 = $request->get('var1');
        $var2 = $request->get('var2');
        $resultat = $calculService->calculate($var1, $var2, $op);
        if (isset($resultat['op'])) {
            // return new Response(
            //     "$var1 " . $resultat['op'] . " $var2 = " . $resultat['value'],
            //     Response::HTTP_OK,
            //     ['content-type' => 'text/plain']
            // );
            return $this->render('calcul/index.html.twig', [
                'controller_name' => "Calcul",
                "var1" => $var1,
                "var2" => $var2,
                "op" => $resultat["op"],
                "resultat" => $resultat["value"],
            ]);
        }
        // return new Response(
        //     $resultat['value'],
        //     Response::HTTP_OK,
        //     ['content-type' => 'text/plain']
        // );
        return $this->render('calcul/index.html.twig', [
            'controller_name' => "Calcul",
            "erreur" => $resultat["value"]
        ]);
    }
}
