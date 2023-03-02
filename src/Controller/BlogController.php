<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleLikeRepository;
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


    #[Route('/article/{id}/like', name: 'article_like')]
    public function like(Article $article, EntityManagerInterface $manager, ArticleLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'code' => 403, 
                'message' => 'Unauthorized : Vous n\'êtes pas connecté!'
            ], 403);
        }

        if ($article->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy(['article' => $article, 'user' => $user]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'label' => 'J\'aime',
                'likes' => $likeRepo->count(['article' => $article])
            ], 200);
        } else {
            $like = new ArticleLike();
            $like->setArticle($article)
                ->setUser($user);
            $manager->persist($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien ajouté',
                'label' => 'Je n\'aime plus',
                'likes' => $likeRepo->count(['article' => $article])
            ], 200);
        }

        // return $this->json(['code' => 200, 'message' => 'Tout fonctionne bien'], 200);
    }
}
