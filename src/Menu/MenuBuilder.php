<?php

namespace App\Menu;

use App\Repository\CategoryRepository;
use Knp\Menu\FactoryInterface;

class MenuBuilder {
    private $factory, $categoryRepository;

    /**
     * @param FactoryInterface $factory
    */
    public function __construct(FactoryInterface $factory, CategoryRepository $categoryRepository)
    {
        $this->factory = $factory;
        $this->categoryRepository = $categoryRepository;
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
        // foreach ($this->categoryRepository->findAll() as $cat) {
        //     $menu->addChild($cat->getName(), [
        //         'route'=>'category_show',
        //         'parameters' => [
        //             'id' => $cat->getId(),
        //         ],
        //         'attributes' => [
        //             'class' => 'nav-item nav d-none'
        //         ],
        //         'childrenAttributes' => [
        //             'class' => 'nav-item'
        //         ],
        //         'linkAttributes' => [
        //             'class' => 'nav-link'
        //         ],
        //     ]);
        // }
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