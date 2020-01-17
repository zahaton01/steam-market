<?php

namespace App\Controller;

use App\Service\Steam\SteamMarketplace;
use App\Service\TMMarketplace\TMCSGOMarketplace;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TMCSGOMarketplace $marketplace)
    {
        $marketplace->retrieveInstance('AK-47 | Redline (Field-Tested)');
    }
}
