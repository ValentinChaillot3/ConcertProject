<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Concert;

class ConcertFixture extends Fixture
{
  
    public function load(ObjectManager $manager): void
    {
      $e1 = new Concert();
      $e1 ->setDate('17/12/2021')
          ->setBand($this->getReference(BandFixture::BAND_USER_REFERENCE));
      $manager->persist($e1);
      $e2 = new Concert();
      $e2 ->setDate('18/12/2021');
      $manager->persist($e2);
      $manager->flush();

    }
    public function getDependencies()
    {
        return [
            BandFixture::class,
        ];
    }
}
