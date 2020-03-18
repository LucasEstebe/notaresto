<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="restaurant")
     * @param RestaurantRepository $restaurantRepository
     * @return Response
     */
    public function index(RestaurantRepository $restaurantRepository)
    {
        $restaurants = $restaurantRepository->findAll();
        return $this->render('restaurant/index.html.twig', [
            'restos' => $restaurants,
        ]);
    }

    /**
     * @Route("/restaurant/new", name="restaurant_form", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        $article = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('restaurant');
        }

        return $this->render('restaurant/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
