<?php

declare(strict_types=1);

namespace Tests\AppBundle\Util;

use AppBundle\Entity\Article;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleTest extends TestCase
{
    public function testSetGet()
    {
        $testName = 'Test Name';
        $testDescription = 'Test Description';
        $testCreatedAt = new \DateTime('2017-01-01 00:00:00');
        $article=new Article();
        $article->setName($testName)
                ->setDescription($testDescription)
                ->setCreatedAt($testCreatedAt);
        //$manager->persist($article);

        $this->assertEquals($testName, $article->getName());
        $this->assertEquals($testDescription, $article->getDescription());
        $this->assertEquals($testCreatedAt, $article->getCreatedAt());
    }
}
