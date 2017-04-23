<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 */
class ArticleController extends Controller
{

    /**
     * @Route("/article", name="article_index")
     */
    public function indexAction()
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $article = $article->findAll();

        return $this->render ( 'article/index.html.twig' ,[
            'article' => $article]);
    }

    /**
     * @return Response
     *
     * @Route("/article/create", name="article_create")
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @Route ("/article/update/{id}", name="article_update")
     * @return Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $articleRepozitory = $em->getRepository(Article::class);
        $article = $articleRepozitory->find($id);
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isValid())  {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $id
     *
     * @Route ("/article/delete/{id}", name="article_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('article_index');
    }
}