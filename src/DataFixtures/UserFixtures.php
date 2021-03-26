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
           ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$TlLAd/1YYUIJM7R/HhQyUA$pOywDlZtdyfJcymX0xbNg40ahr11y4GynLY7ZDzWOjY');

       $manager->persist($user);
       $manager->flush();
    }
}
