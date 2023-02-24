<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function showArticle(Article $article, Request $request, EntityManagerInterface $manager): Response 
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticle($article);
            $comment->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_show_article', ['id' => $article->getId()]);
        }

        return $this->render('blog/show_article.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
