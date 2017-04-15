<?php
/**
 * Created by PhpStorm.
 * User: Michael-mac
 * Date: 13.04.17
 * Time: 12:54
 * Можно удалить
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class LuckyController
 * @package AppBundle\Controller
 */
class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return $this -> render ( 'lucky/number.html.twig' , array (
            'number' => $number
        ));
    }
}