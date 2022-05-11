<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Room;
use App\Repository\HotelRepository;
use App\Repository\MessagesRepository;
use App\Repository\RoomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    #[Route('/hotel', name: 'app_hotel')]
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }

    #[Route('/hotel/create', name: 'app_hotel_create')]
    public function createHotel(Request $request, ManagerRegistry $doctrine): Response
    {
       $hotel = new Hotel();

        $form = $this->createForm(\HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $hotel = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($hotel);
            $entityManager->flush();
            return new Response('Hotel added successfully');
        }
        return $this->renderForm('hotel/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/hotel/show', name: 'app_hotel_show')]
    public function showAllHotel(HotelRepository $hotelRepository): Response
    {
        $allHotels = $hotelRepository->findAll();
        return $this->render('hotel/show.html.twig', [
            'allHotels' => $allHotels
        ]);
    }

    #[Route('/hotel/{id}', name: 'app_hotel_view')]
    public function editHotel(Request $request, Hotel $hotel,  ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(\HotelType::class, $hotel);

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $hotel = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($hotel);
            $entityManager->flush();
            return new Response('Hotel updated successfully');
        }
        return $this->renderForm('hotel/view.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/hotel/delete/{id}', name: 'app_hotel_delete')]
    public function deleteHotel(Hotel $hotel,  ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($hotel);
        $entityManager->flush();

        return $this->redirectToRoute('app_hotel_show');
    }


    //--------------------------------------

    #[Route('/room/create', name: 'app_room_create')]
    public function createRoom(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $hotelRep = $entityManager->getRepository(Hotel::class);
        if ($request->getMethod()=="POST") {
            $bedSize = $request->request->get("bedSize");
            $price = $request->request->get("price");
            $roomStatus = $request->request->get("roomStatus");
            $hotelId = $request->request->get("allHotel");
            $hotel = $hotelRep->find($hotelId);
            $room = new Room();
            $room->setBedSize($bedSize);
            $room->setPrice($price);
            $room->setIsEmpty($roomStatus);
            $room->setHotel($hotel);


            $entityManager->persist($room);
            $entityManager->flush();
            return new Response('Room added successfully');
        }
        $entityManager = $doctrine->getManager();
        $hotelRep = $entityManager->getRepository(Hotel::class);
        $allHotels = $hotelRep->findAll();
        return $this->renderForm('room/index.html.twig', [
            'hotels' => $allHotels
        ]);
    }

    #[Route('/room/show', name: 'app_room_show')]
    public function showAllRoom(RoomRepository $roomRepository): Response
    {
        $allRooms = $roomRepository->findAll();
        return $this->render('room/show.html.twig', [
            'allRoom' => $allRooms
        ]);
    }

    #[Route('/room/{id}', name: 'app_room_view')]
    public function editRoom(Request $request, Room $room,  ManagerRegistry $doctrine): Response
    {
        if ($request->getMethod() == "POST") {
            $bedSize = $request->request->get("bedSize");
            $price = $request->request->get("price");
            $roomStatus = $request->request->get("roomStatus");
            $hotelId = $request->request->get("allHotel");
            $entityManager = $doctrine->getManager();
            $hotelRep = $entityManager->getRepository(Hotel::class);
            $hotel = $hotelRep->find($hotelId);
            $room->setBedSize($bedSize);
            $room->setPrice($price);
            if($roomStatus){
                $room->setIsEmpty(false);
            }else{
                $room->setIsEmpty(true);
            }
            $room->setHotel($hotel);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($room);
            $entityManager->flush();
            return new Response('Room updated successfully');
        }
        $entityManager = $doctrine->getManager();
        $hotelRep = $entityManager->getRepository(Hotel::class);
        $allHotels = $hotelRep->findAll();
        return $this->renderForm('room/view.html.twig', [
            'hotels' => $allHotels,
            'room' => $room
        ]);
    }

    #[Route('/room/delete/{id}', name: 'app_room_delete')]
    public function deleteRoom(Room $room, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($room);
        $entityManager->flush();

        return $this->redirectToRoute('app_room_show');
    }
}
