<?php

namespace App\Controller;

use App\Factory\CS\CSItemFactory;
use App\Factory\CS\Resolver\CSFactoryResolver;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CSFactoryResolver $factoryResolver)
    {
        //$marketplace->retrieveInstance('AK-47 | Redline (Field-Tested)');
        //$res = $marketplace->retrieveItemSells('AK-47 | Redline (Field-Tested)');

        //var_dump($res->getSells());
        exit;
    }
}
