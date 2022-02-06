<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;

class ArtistFixture extends Fixture
{
  public const ARTIST_USER_REFERENCE = 'band-member';
  public const ARTIST_USER_REFERENCE2 = 'band-member2';
    public function load(ObjectManager $manager): void
    {
$a1 = new Artist();
$a1 ->setName('Reynolds')
    ->setFirstName('Dan')
    ->setJob('Chanteur');
        $manager->persist($a1);
$a2 = new Artist();
$a2 ->setName('Sermon')
    ->setFirstName('Wayne')
    ->setJob('Guitariste');
        $manager->persist($a2);

        $manager->flush();
        $this->addReference(self::ARTIST_USER_REFERENCE, $a1);
        $this->addReference(self::ARTIST_USER_REFERENCE2, $a2);
    }
}
