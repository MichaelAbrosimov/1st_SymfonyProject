<?php

declare(strict_types=1);

namespace Tests\AppBundle\Util;

use AppBundle\Entity\Article;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleTest extends TestCase
{
    public function testName()
    {
        $testName = 'Test Name';
        $article = new Article();
        $article->setName($testName);
        $this->assertEquals($testName, $article->getName());
    }

    public function testDescription()
    {
        $testDescription = 'Test Description';
        $article = new Article();
        $article->setDescription($testDescription);
        $this->assertEquals($testDescription, $article->getDescription());
    }

    public function testCreatedAt()
    {
        $testCreatedAt = new \DateTime('2017-01-01 00:00:00');;
        $article = new Article();
        $article->setCreatedAt($testCreatedAt);
        $this->assertEquals($testCreatedAt, $article->getCreatedAt());
    }
}
