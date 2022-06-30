<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy([], ['created_at' => 'DESC']);

        return $this->render('blog/index.html.twig', [
            'articles' => $articles 
        ]);
    }

    #[Route('/article/{id<[0-9]+>}', name: 'app_show_article')]
    public function showArticle(Article $article): Response 
    {
        return $this->render('blog/show_article.html.twig', [
            'article' => $article
        ]);
    }
}
