<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index()
    {
        $restos = $this->getDoctrine()->getRepository(Restaurant::class)->findBest(10);
        return $this->render('app/index.html.twig', [
            'restos' => $restos,
        ]);
    }
}
