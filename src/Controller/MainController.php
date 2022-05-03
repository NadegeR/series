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
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/test", name="main-test")
     */
    public function test(){

        $serie = [
            "title" => "<h1>Game of Thrones</h1>",
            "year"=> 2000
        ];

        return $this->render('main/test.html.twig', ["mySerie"=> $serie]);
    }

}