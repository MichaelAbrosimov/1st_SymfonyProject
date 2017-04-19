<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ArticleController extends Controller
{

    /**
     * @Route("/article/controller")
     */
    public function createGreed()
    {
        return $this->render ( 'article/articleGreed.html.twig' , array (
            'name' => "Article"));
    }

}