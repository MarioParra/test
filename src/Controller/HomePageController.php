<?php

namespace App\Controller;


use App\Entity\RoomTypeQuantity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * Controller to show home page and a search form to display hotel's rooms availability
 * Class HomePageController
 * @package App\Controller
 */
class HomePageController extends AbstractController
{
    private $warning_messages = [];

    /**
     * @Route("/home/page", name="home_page")
     */
    public function index()
    {

        return $this->render('home_page/index.html.twig', [
            'search_form' => $this->getSearchForm('search')->createView()
        ]);
    }

    /**
     * Action to manage search action made by user
     * Show a list of available rooms by type
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $form = $this->getSearchForm('search');
        $form->handleRequest($request);

        $rooms = [];

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $room_quantity_repo = $entityManager->getRepository(RoomTypeQuantity::class);
            $rooms = $room_quantity_repo->findByDateRangeAndOccupation($data['check_in_date'], $data['check_out_date'], $data['occupation']);

            if(count($rooms) == 0) {
                $this->warning_messages[] = 'There is no rooms available for your criteria';
            }
        }

        return $this->render('home_page/search.html.twig', [
            'search_form' => $form->createView(),
            'messages'    => $this->warning_messages,
            'rooms'       => $rooms
        ]);
    }

    /**
     * Get a brand new search form. It can be configurable by route
     * @param $route
     * @return \Symfony\Component\Form\FormInterface
     */
    private function getSearchForm($route)
    {
        $form = $this->createFormBuilder(null)
            ->add('check_in_date',  DateType::class)
            ->add('check_out_date', DateType::class)
            ->add('occupation',     IntegerType::class)
            ->add('search', SubmitType::class, array('label' => 'Search!'))
            ->setMethod('POST')
            ->setAction($this->generateUrl($route))
            ->getForm();

        return $form;
    }
}
