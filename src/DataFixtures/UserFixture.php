<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserFixture extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $u1 = new User();
        $u1 ->setEmail('admin@gmail.com')
            ->setPassword('123456')
            ->setFirstName('Admin')
            ->setLastName('Admin')
            ->setRoles(array('ROLE_USER','ROLE_ADMIN'));
        $password = $this->hasher->hashPassword($u1, '123456');
        $u1->setPassword($password);
        $manager->persist($u1);

        $manager->flush();
    }
}
