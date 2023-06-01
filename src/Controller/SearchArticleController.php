<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchArticleController extends AbstractController
{
    #[Route('/search/article', name: 'app_search_article')]
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $search = $request->request->get('your-search');
        $articlesResult = $articleRepository->findByTitle($search);
        
        return $this->render('search_article/index.html.twig', [
            'articlesResult' => $articlesResult,
        ]);
    }
}
