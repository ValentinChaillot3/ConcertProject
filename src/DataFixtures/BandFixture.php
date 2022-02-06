<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Band;

class BandFixture extends Fixture
{
    public const BAND_USER_REFERENCE = 'band-members';
    public function load(ObjectManager $manager): void
    {
      $b1 = new Band();
      $b1 ->setName('Imagine Dragons')
          ->setPicture('images/imagineDragons.jpg')
          ->addMember($this->getReference(ArtistFixture::ARTIST_USER_REFERENCE))
          ->addMember($this->getReference(ArtistFixture::ARTIST_USER_REFERENCE2));
              $manager->persist($b1);
        $manager->flush();
        $this->addReference(self::BAND_USER_REFERENCE, $b1);
    }
    public function getDependencies()
   {
       return [
           ArtistFixture::class,
       ];
   }
}
