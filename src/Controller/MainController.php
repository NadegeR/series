<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main-home")
     */
    public function home(){
        echo"coucou";
        die();
    }

    /**
     * @Route("/test", name="main-test")
     */
    public function test(){
        echo"test";
        die();
    }

}