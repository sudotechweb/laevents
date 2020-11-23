<?php

namespace App\Menu;

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
        $options = [
            'attribute' => ['class' => 'test'],
        ];
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttributes(['class' => 'navbar-nav justify-content-center mr-auto mt-2 mt-lg-0']);
        $menu->addChild('Home', [
            'route'=>'home',
            'attributes' => [
                'class' => 'nav-item nav'
            ],
            'childrenAttributes' => [
                'class' => 'nav-item'
            ],
            'linkAttributes' => [
                'class' => 'nav-link'
            ],
        ]);
        // $menu->addChild('Events', [
        //     'route'=>'event_index',
        //     'attributes' => [
        //         'class' => 'nav-item nav'
        //     ],
        //     'childrenAttributes' => [
        //         'class' => 'nav-item'
        //     ],
        //     'linkAttributes' => [
        //         'class' => 'nav-link'
        //     ],
        // ]);
        $menu->addChild('Categories', [
            'route'=>'event_category_index',
            'attributes' => [
                'class' => 'nav-item nav'
            ],
            'childrenAttributes' => [
                'class' => 'nav-item'
            ],
            'linkAttributes' => [
                'class' => 'nav-link'
            ],
        ]);
        $menu->addChild('Associations', [
            'route'=>'event_association_index',
            'attributes' => [
                'class' => 'nav-item nav'
            ],
            'childrenAttributes' => [
                'class' => 'nav-item'
            ],
            'linkAttributes' => [
                'class' => 'nav-link'
            ],
        ]);
        $menu->addChild('Contact Us', [
            'route'=>'contact',
            'attributes' => [
                'class' => 'nav-item nav'
            ],
            'childrenAttributes' => [
                'class' => 'nav-item'
            ],
            'linkAttributes' => [
                'class' => 'nav-link'
            ],
        ]);
        $menu->addChild('About Us', [
            'route'=>'about',
            'attributes' => [
                'class' => 'nav-item nav'
            ],
            'childrenAttributes' => [
                'class' => 'nav-item'
            ],
            'linkAttributes' => [
                'class' => 'nav-link'
            ],
        ]);
        return $menu;
    }
}