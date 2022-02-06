<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Organisation;

class OrganisationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $d1 = new Organisation();
      $d1 ->setName('jsp')
          ->setMail('jsp@gmail.com')
          ->setPhone('0700582136');
      $manager->persist($d1);

      $manager->flush();
    }
}
