<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class RandomTextGenerator
{
    private $catRepo;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->catRepo = $categoryRepository;
    }

    public function randomWord()
    {
        $titles = ['lorem', 'ipsum', 'dolor', 'sit', 'amet', 'qui', 'minim', 'labore', 'adipisicing', 'minim', 'sint', 'cillum', 'sint', 'consectetur', 'cupidatat'];
        return $titles[rand(0,14)];
    }

    public function randomTitle()
    {
        $titles = ['lorem', 'ipsum', 'dolor', 'sit', 'amet', 'qui', 'minim', 'labore', 'adipisicing', 'minim', 'sint', 'cillum', 'sint', 'consectetur', 'cupidatat'];
        $title = '';
        for ($i=0; $i < rand(3,12); $i++) { 
            $title = $title . $titles[rand(0,14)].' ';
        }
        return $title;
    }

    public function randomSentence()
    {
        $sentences = [
            'Lorem ipsum dolor sit amet, officia excepteur ex fugiat reprehenderit enim labore culpa sint ad nisi Lorem pariatur mollit ex esse exercitation amet',
            'Nisi anim cupidatat excepteur officia',
            'Reprehenderit nostrud nostrud ipsum Lorem est aliquip amet voluptate voluptate dolor minim nulla est proident',
            'Nostrud officia pariatur ut officia',
            'Sit irure elit esse ea nulla sunt ex occaecat reprehenderit commodo officia dolor Lorem duis laboris cupidatat officia voluptate',
            'Culpa proident adipisicing id nulla nisi laboris ex in Lorem sunt duis officia eiusmod',
            'Aliqua reprehenderit commodo ex non excepteur duis sunt velit enim',
            'Voluptate laboris sint cupidatat ullamco ut ea consectetur et est culpa et culpa duis',
        ];
        $sentence = '';
        $counter = rand(2,5);
        for ($i=0; $i < $counter; $i++) { 
            $sentence = $sentence . $sentences[rand(0,7)].'. ';
        }
        return $sentence;
        // return $sentences[rand(0,7)];
    }
}