<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder {
    private $factory;

    /**
     * @param FactoryInterface $factory
    */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $options = [
            'attribute' => ['class' => 'test'],
        ];
        $menu = $this->factory->createItem('root');
        $menu->addChild('Home', ['route'=>'home', 'options' => ['ancestorClass' => 'test-ancestor', 'branchClass' => 'test-branch'], ]);
        return $menu;
    }
}