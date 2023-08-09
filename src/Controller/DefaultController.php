<?php

namespace App\Controller;

use App\Repository\PlayersRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'main_page')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/players', name: 'players')]
    public function players(PlayersRepository $playersRepository): Response{

        $players = $playersRepository->findAll();

        $encoder = new JsonEncoder();
        $defaultContent = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context){
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContent);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContent = ($serializer->serialize($players, 'json'));

        $response = new Response;

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return new Response($jsonContent);
    }

    #[Route('/team1', name: 'first_team')]
    public function team1(PlayersRepository $players): Response{

        $playerTeam1 = $players->findBy(['equipe' => '1']);

        return $this->render('default/team1.html.twig', [
            'playerTeam1' => $playerTeam1, 
        ]);
    }
}
