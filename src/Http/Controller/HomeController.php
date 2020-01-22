<?php

namespace App\Http\Controller;

use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        //$marketplace->retrieveInstance('AK-47 | Redline (Field-Tested)');
        //$res = $marketplace->retrieveItemSells('AK-47 | Redline (Field-Tested)');

        //var_dump($res->getSells());
        exit;
    }
}
