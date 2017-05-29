<?php
/**
 * Created by PhpStorm.
 * User: Michael-mac
 * Date: 29.05.17
 * Time: 22:49
 */

namespace Tests\AppBundle\Util;

use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;
use PHPUnit\Framework\TestCase;

class InterfaceSymfonyTest extends TestCase
{
    public function testName()
    {
        $testName = 'Test Name';
        $interface = new InterfaceSymfony();
        $interface->setName($testName);
        $this->assertEquals($testName, $interface->getName());
    }

    public function testURL()
    {
        $testURL = 'Test URL';
        $interface = new InterfaceSymfony();
        $interface->setUrl($testURL);
        $this->assertEquals($testURL, $interface->getUrl());
    }

    public function testNamespace()
    {
        $testNamespace = new NamespaceSymfony();
        $interface = new InterfaceSymfony();
        $interface->setNamespace($testNamespace);
        $this->assertEquals($testNamespace, $interface->getNamespace());
    }
}
