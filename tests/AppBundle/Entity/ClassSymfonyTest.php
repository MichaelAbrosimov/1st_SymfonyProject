<?php


declare(strict_types=1);

namespace Tests\AppBundle\Util;

use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\NamespaceSymfony;
use PHPUnit\Framework\TestCase;

/**
 * Class ClassSymfonyTest
 * @package Tests\AppBundle\Util
 */
class ClassSymfonyTest extends TestCase
{
    public function testName()
    {
        $testName = 'Test Name';
        $class = new ClassSymfony();
        $class->setName($testName);
        $this->assertEquals($testName, $class->getName());
    }

    public function testURL()
    {
        $testURL = 'Test URL';
        $class = new ClassSymfony();
        $class->setUrl($testURL);
        $this->assertEquals($testURL, $class->getUrl());
    }

    public function testNamespace()
    {
        $testNamespace = new NamespaceSymfony();
        $class = new ClassSymfony();
        $class->setNamespace($testNamespace);
        $this->assertEquals($testNamespace, $class->getNamespace());
    }
}
