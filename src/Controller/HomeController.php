<?php

namespace App\Controller;

use App\Service\Steam\SteamMarketplace;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SteamMarketplace $marketplace)
    {
        $res = $marketplace->getCsGoItemMetaData('StatTrak™ Five-SeveN | Copper Galaxy (Factory New)', 6);
        var_dump($res);
        exit;
    }
}