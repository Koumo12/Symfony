<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
USE Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route ("lucky", name="app_lucky_number")
     */

    public function number(): Response
    {
       $number = random_int(0, 100);
       
       return new Response("<html><body>{$number}</body></html>");
    } 

    /**
     * Affichez les données avec html.twig
     * 
     * @Route ("random")
     */

    public function random(): Response
    {
       return $this->render("/lucky/number.html.twig", ["number"=> random_int(0,100)]);
    } 



}
