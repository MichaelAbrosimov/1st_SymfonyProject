<?php
/**
 * Created by PhpStorm.
 * User: Michael-mac
 * Date: 21.05.17
 * Time: 14:45
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadArticleData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $article_1 = new Article();
        $article_1->setName('t1')
            ->setDescription('test1')
            ->setCreatedAt(new \DateTime('2017-05-20 09:22:00'));

        $article_2 = new Article();
        $article_2->setName('t2')
            ->setDescription('test2')
            ->setCreatedAt(new \DateTime("2017-01-01 11:41:00"));

        $manager->persist($article_1);
        $manager->persist($article_2);
        $manager->flush();

    }
}
