<?php
/**
 * Created by PhpStorm.
 * User: Michael-mac
 * Date: 26.04.17
 * Time: 19:36
 */

namespace AppBundle\Comand;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SymfonyParser extends Controller
{
    /**
     *@Route("/parser", name="parser")
     */
    public function parser()
    {
       $content = file_get_contents('http://api.symfony.com');
       var_dump($content);
       return $this->render();
    }

}