<?php

namespace App\Controller;

use App\Service\PlayersService;
use App\Repository\StaffRepository;
use App\Repository\PlayersRepository;
use App\Service\StaffService;
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

    #[Route('/staff_members', name: 'staff_members')]
    public function staff_members(StaffRepository $staffRepository): Response{
        $staff = $staffRepository->findAll();

        $encoder = new JsonEncoder();
        $defaultContent = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context){
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContent);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContent = ($serializer->serialize($staff, 'json'));

        $response = new Response;

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return new Response($jsonContent);
    }

    #[Route('/team1', name: 'first_team')]
    public function team1(PlayersRepository $players, PlayersService $playersService): Response{

        $playerTeam1 = $players->findBy(['equipe' => '1']);

        foreach($playerTeam1 as $player){

            $age = $playersService->calculateAge($player->getBirthDate());

            $player->setAge($age);
        }

        return $this->render('default/team1.html.twig', [
            'playerTeam1' => $playerTeam1, 
        ]);
    }

    #[Route('/team2', name: 'women_team')]
    public function team2(PlayersRepository $players, PlayersService $playersService): Response{

        $playerTeam2 = $players->findBy(['equipe' => '2']);

        foreach($playerTeam2 as $player){

            $age = $playersService->calculateAge($player->getBirthDate());

            $player->setAge($age);
        }

        return $this->render('default/team2.html.twig', [
            'playerTeam2' => $playerTeam2, 
        ]);
    }

    #[Route('/team3', name: 'U23_team')]
    public function team3(PlayersRepository $players, PlayersService $playersService): Response{

        $playerTeam3 = $players->findBy(['equipe' => '3']);

        foreach($playerTeam3 as $player){

            $age = $playersService->calculateAge($player->getBirthDate());

            $player->setAge($age);
        }

        return $this->render('default/team3.html.twig', [
            'playerTeam3' => $playerTeam3, 
        ]);
    }

    #[Route('/staff', name: 'staff')]
    public function staff(StaffRepository $staff, StaffService $staffService): Response{
        $staff_members = $staff->findAll();

        foreach($staff_members as $staff){

            $age = $staffService->calculateAge($staff->getBirthDate());
            // $seniority = $staffService->calculateSeniority($staff->getAuClubDepuis());

            $staff->setAge($age);
            // $staff->setAuClubDepuis($seniority);
        }
        
        return $this->render('default/staff.html.twig', [
            'staff_members' => $staff_members,
        ]);
    }
}
