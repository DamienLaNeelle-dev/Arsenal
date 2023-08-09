<?php

namespace App\Service;

use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlayersService extends AbstractController{
    public function calculateAge($birthDate)
    {
        $now = new \DateTime();
        $difference = $now->diff($birthDate);
        $age = $difference->y;

        return $age;
    }

}

?>