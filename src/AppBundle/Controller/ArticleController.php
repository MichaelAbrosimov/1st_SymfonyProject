<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ArticleController extends Controller
{

    /**
     * @Route("/article/controller", name="article_index")
     */
    public function createGreed()
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $article = $article->findAll();
        var_dump($article);
        return $this->render ( 'article/articleGreed.html.twig' , array (
            'article' => $article));
        return;
    }
}