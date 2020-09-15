<?php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security;

class MenuBuilder
{
    private $factory;

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory, Security $security)
    {
        
        $this->security = $security;
        $this->factory = $factory;

    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root', array(
                'navbar' => true,
        ));
        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto');
        $menu->addChild('Projects', ['route' => 'project'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link'));
        
        if ($user = $this->security->getUser()) {
            $menu->addChild('Works')->setAttribute('dropdown',true) ;
            $menu['Works']->addChild('List Works', ['route' => 'film'])
                    ->setAttributes(array('class' => 'nav-item'))
                    ->setLinkAttributes(array('class'=> 'nav-link text-primary'));
                
            $menu['Works']->addChild('Create Work', ['route' => 'film/new'])
                    ->setAttributes(array('class' => 'nav-item '))
                    ->setLinkAttributes(array('class'=> 'nav-link text-primary'));
                }
        else {
            $menu->addChild('Works', ['route' => 'film'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link'));
        }

        return $menu;
    }

    public function createUserMenu(array $options): ItemInterface
    {
        
        
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ');
        if ($user = $this->security->getUser()) {
            $menu->addChild('Logout', ['route' => 'security_registration'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link '));
        }
        else{
            $menu->addChild('Login', ['route' => 'security_login'])
                    ->setAttributes(array('class' => 'nav-item'))
                    ->setLinkAttributes(array('class'=> 'nav-link bg-primary'));
            $menu->addChild('Register', ['route' => 'security_registration'])
                    ->setAttributes(array('class' => 'nav-item'))
                    ->setLinkAttributes(array('class'=> 'nav-link '));
            }

        return $menu;
    }
}
?>