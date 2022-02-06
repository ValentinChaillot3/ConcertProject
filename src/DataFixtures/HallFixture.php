<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hall;

class HallFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $c1 = new Hall();
      $c1 ->setName('Freak Show')
          ->setSeats('200')
          ->setAdress('3 Rue Lunaret');

      $manager->persist($c1);

      $c2 = new Hall();
      $c2 ->setName('Le Jam')
          ->setSeats('400')
          ->setAdress('100 Rue Ferdinand de Lesseps');

      $manager->persist($c2);
      $manager->flush();
    }
}
