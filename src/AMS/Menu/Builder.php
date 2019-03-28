<?php

declare(strict_types=1);

namespace App\AMS\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function mainMenu(RequestStack $requestStack): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto');
        $menu->addChild('Recipe', ['route' => 'recipe']);
        $menu->addChild('Add Recipe', ['route' => 'add-recipe']);

        // menu items
        foreach ($menu as $child) {
            $child->setLinkAttribute('class', 'nav-link')
                ->setAttribute('class', 'nav-item');
        }

        return $menu;
    }
}
