<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $user = new User();
       $user->setUsername('Jonathan')
           ->setPassword('$argon2i$v=19$m=65536,t=4,p=1$QmNnQTdsUVI2NlhzeVY4MA$VJx7+YHvzXiV85KkZ2ftjgdHy3sPkcvQ4vNvIgPCt2E');

       $manager->persist($user);
       $manager->flush();
    }
}
