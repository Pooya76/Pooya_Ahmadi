<?php

namespace App\Controller;

use App\Repository\AttractionRepository;
use App\Entity\Attraction;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class AttractionController extends AbstractController
{
    #[Route('/attractions', name: 'app_attraction')]
    public function index(AttractionRepository $attractionRepository): Response
    {
        $attractions = $attractionRepository->findAll();
        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractions
        ]);
    }


    #[Route('/attraction/new', name: 'app_attraction_new')]
    public function new(Request $request, AttractionRepository $attractionRepository): Response
    {

        if ($request->isMethod("POST")) {

            $name = $request->get("name");
            $shortDescription = $request->get("short_description");
            $fullDescription = $request->get("full_description");
            $score = $request->get("score");

            $attraction = new Attraction();
            $attraction->setName($name);
            $attraction->setShortDescription($shortDescription);
            $attraction->setFullDescription($fullDescription);
            $attraction->setScore($score);
            $attraction->setCreatedAt(new DateTimeImmutable());
            $attraction->setUpdatedAt(new DateTimeImmutable());

            $attractionRepository->add($attraction);
        }

        return $this->render('attraction/new.html.twig');
    }


    #[Route('/attraction/edit/{id}', name: 'app_attraction_edit')]
    public function edit(Request $request, AttractionRepository $attractionRepository,Attraction $attraction, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod("POST")) {

            $name = $request->get("name");
            $shortDescription = $request->get("short_description");
            $fullDescription = $request->get("full_description");
            $score = $request->get("score");

            $attraction->setName($name);
            $attraction->setShortDescription($shortDescription);
            $attraction->setFullDescription($fullDescription);
            $attraction->setScore($score);
            $attraction->setUpdatedAt(new DateTimeImmutable());

            $entityManager->flush();
        }

        return $this->render('attraction/edit.html.twig', ['attraction' => $attraction]);
    }

    #[Route('/attraction/{id}', name: 'app_attraction_view')]
    public function view(Attraction $attraction): Response
    {
        return $this->render('attraction/view.html.twig',['attraction' => $attraction]);
    }

    #[Route('/attraction/delete/{id}', name: 'app_attraction_delete')]
    public function delete(Attraction $attraction, AttractionRepository $attractionRepository): Response
    {
        $attractionRepository->remove($attraction);

        return $this->redirectToRoute('app_attraction');
    }
}
