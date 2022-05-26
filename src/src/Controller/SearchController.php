<?php

namespace App\Controller;

use App\Search\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, SearchService $searchService): Response
    {
        $query = $request->query->get('query');
        $hotels = $searchService->searchHotel($query);
        return $this->render('search/index.html.twig', [
            'hotels' => $hotels,
        ]);
    }
}
