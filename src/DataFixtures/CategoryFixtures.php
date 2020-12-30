<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Service\RandomTextGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private $randomtext;
    public function __construct(RandomTextGenerator $randomTextGenerator)
    {
        $this->randomtext = $randomTextGenerator;
    }

    public function load(ObjectManager $manager)
    {
        $colors = ['#f00','#980101','#fff700','#1e00ff','#03bd00','#7628a7','#2a28a7','#28a795','#a76328','#ff76c8','#76c0ff','#480543'];
        for ($g=0; $g < 12; $g++) { 
            $cat = new Category();
            $cat
                ->setName($this->randomtext->randomWord())
                ->setDescription($this->randomtext->randomSentence())
                ->setColor($colors[$g])
            ;
            $manager->persist($cat);
        }

        $manager->flush();
    }
}
