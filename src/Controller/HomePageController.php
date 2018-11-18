<?php

namespace App\Controller;

use App\Entity\RoomPrice;
use App\Entity\RoomType;
use App\Entity\RoomTypeQuantity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home/page", name="home_page")
     */
    public function index()
    {


        return $this->render('home_page/index.html.twig', [

        ]);
    }
}
