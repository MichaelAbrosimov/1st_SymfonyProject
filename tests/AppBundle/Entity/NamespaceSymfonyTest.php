<?php

namespace Tests\AppBundle\Util;

use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\NamespaceSymfony;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class NamespaceSymfonyTest extends TestCase
{
    public function testName()
    {
        $testName = 'Test Name';
        $namespace = new NamespaceSymfony();
        $namespace->setName($testName);
        $this->assertEquals($testName, $namespace->getName());
    }

    public function testURL()
    {
        $testURL = 'Test URL';
        $namespace = new NamespaceSymfony();
        $namespace->setUrl($testURL);
        $this->assertEquals($testURL, $namespace->getUrl());
    }

    public function testParentNamespace()
    {
        $testParentNamespace = new NamespaceSymfony();
        $namespace = new NamespaceSymfony();
        $namespace->setParentNamespace($testParentNamespace);
        $this->assertEquals($testParentNamespace, $namespace->getParentNamespace());
    }


    public function testLeft()
    {
        $testLeft = 1;
        $namespace = new NamespaceSymfony();
        $namespace->setLeft($testLeft);
        $this->assertEquals($testLeft, $namespace->getLeft());
    }

    public function testRight()
    {
        $testRight = 2;
        $namespace = new NamespaceSymfony();
        $namespace->setRight($testRight);
        $this->assertEquals($testRight, $namespace->getRight());
    }

    public function testLevel()
    {
        $testLevel = 3;
        $namespace = new NamespaceSymfony();
        $namespace->setLevel($testLevel);
        $this->assertEquals($testLevel, $namespace->getLevel());
    }

    public function testRoot()
    {
        $testRoot = 4;
        $namespace = new NamespaceSymfony();
        $namespace->setRoot($testRoot);
        $this->assertEquals($testRoot, $namespace->getRoot());
    }

    public function testId()
    {
        $namespace = new NamespaceSymfony();
        $this->assertEquals(null , $namespace->getId());
    }

    public function testClasses()
    {
        $namespace = new NamespaceSymfony();
        $class = new ClassSymfony();
        $class->setNamespace($namespace);
        var_dump($namespace);
        var_dump($class);
        $this->assertTrue(is_a(($namespace->getClasses()), 'ArrayCollection')) ;
      //127.0.0.1  $this->assertClassHasAttribute( ('arraycollection',$namespace->getClasses());
    }
}
