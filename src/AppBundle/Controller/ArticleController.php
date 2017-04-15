<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class ArticleController
{

    /**
     * @Route("/article/controller")
     */
    public function createGreed()
    {
        return new Response("<htm><body>Здесь будет таблица</body></html>");
    }

}