<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userFirst = new User();
        $userFirst->setUsername('trash');
        $userFirst->setPassword(password_hash('0000', PASSWORD_BCRYPT));
        $manager->persist($userFirst);
        $manager->flush();
    }
}
