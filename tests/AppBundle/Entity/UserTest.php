<?php
/**
 * Created by PhpStorm.
 * User: Michael-mac
 * Date: 01.06.17
 * Time: 21:14
 */

namespace Tests\AppBundle\Util;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUsername()
    {
        $testUserName = 'Test Name';
        $user = new User();
        $user->setUsername($testUserName);
        $this->assertEquals($testUserName, $user->getUsername());
    }

    public function testPassword()
    {
        $testPassword = 'Password';
        $user = new User();
        $user->setPassword($testPassword);
        $this->assertEquals($testPassword, $user->getPassword());
    }

    public function testRoles()
    {
        $user = new User();
        $this->assertInternalType('array', $user->getRoles());
    }
}
