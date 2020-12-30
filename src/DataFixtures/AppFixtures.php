<?php

namespace App\DataFixtures;

use App\Entity\Appuser;
use App\Entity\Association;
use App\Service\RandomTextGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $upei, $namegen;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface, RandomTextGenerator $randomTextGenerator)
    {
        $this->upei = $userPasswordEncoderInterface;
        $this->namegen = $randomTextGenerator;
    }

    public function load(ObjectManager $manager)
    {
        $appuser = new Appuser();
        $appuser
            ->setEmail('admin@laevents.com')
            ->setPassword($this->upei->encodePassword($appuser,'password'))
            ->setRoles(['ROLE_ADMIN'=>'ROLE_ADMIN'])
        ;
        $manager->persist($appuser);

        foreach ([0,1,2] as $key) {
            $association = new Association();
            $association->setName($this->namegen->randomWord());
            $manager->persist($association);
        }

        $manager->flush();
    }
}
