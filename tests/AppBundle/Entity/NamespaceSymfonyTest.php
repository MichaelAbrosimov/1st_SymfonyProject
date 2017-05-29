<?php
/**
 * Created by PhpStorm.
 * User: Michael-mac
 * Date: 29.05.17
 * Time: 23:00
 */

namespace Tests\AppBundle\Util;

use AppBundle\Entity\NamespaceSymfony;
use PHPUnit\Framework\TestCase;

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
}
