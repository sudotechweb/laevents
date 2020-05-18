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

    public function createMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Home', ['route'=>'home']);
        return $menu;
    }
}