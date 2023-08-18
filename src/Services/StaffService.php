<?php

namespace App\Service;

use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StaffService extends AbstractController{
    public function calculateAge($birthDate)
    {
        $now = new \DateTime();
        $difference = $now->diff($birthDate);
        $age = $difference->y;

        return $age;
    }

    // public function calculateSeniority($au_club_depuis)
    // {
    //     $now = new \DateTime();
    //     $difference = $now->diff($au_club_depuis);
    //     $seniority = $difference->y;

    //     return $seniority;
    // }
}

?>