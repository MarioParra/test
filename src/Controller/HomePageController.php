<?php

namespace App\Controller;

use App\Entity\RoomPrice;
use App\Entity\RoomType;
use App\Entity\RoomTypeQuantity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private $messages = [];

    /**
     * @Route("/home/page", name="home_page")
     */
    public function index()
    {

        return $this->render('home_page/index.html.twig', [
            'search_form' => $this->getSearchForm()->createView()
        ]);
    }

    public function search(Request $request)
    {
        $form = $this->getSearchForm();
        $form->handleRequest($request);

        $data = [];

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $room_quantity_repo = $entityManager->getRepository(RoomTypeQuantity::class);
            $rooms = $room_quantity_repo->findByDateRangeAndQuantity($data['check_in_date'], $data['check_out_date']);

        }

        return $this->render('home_page/search.html.twig', [
            'search_form' => $form->createView(),
            'form_data'   => print_r($data, 1),
            'messages'    => $this->messages,
            'rooms'       => print_r($rooms, 1)
        ]);
    }

    private function getSearchForm()
    {
        $form = $this->createFormBuilder(null)
            ->add('check_in_date',  DateType::class)
            ->add('check_out_date', DateType::class)
            ->add('occupation',     IntegerType::class)
            ->add('search', SubmitType::class, array('label' => 'Search!'))
            ->setMethod('POST')
            ->setAction($this->generateUrl('search'))
            ->getForm();

        return $form;
    }
}
