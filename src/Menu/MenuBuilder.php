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
        $menu->addChild('projects', ['route' => 'project'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link'));
                
        //Accès au lien de création des oeuvres si l'utilisateur est authentifié
        if ($user = $this->security->getUser()) {
            $menu->addChild('works')->setAttribute('dropdown',true) ;
            $menu['works']->addChild('List Works', ['route' => 'film'])
                    ->setAttributes(array('class' => 'nav-item'))
                    ->setLinkAttributes(array('class'=> 'nav-link text-primary'));
                
            $menu['works']->addChild('Create Work', ['route' => 'film_create'])
                    ->setAttributes(array('class' => 'nav-item '))
                    ->setLinkAttributes(array('class'=> 'nav-link text-primary'));
                }
        else {
            $menu->addChild('works', ['route' => 'film'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link'));
        }

        $menu->addChild('statistics', ['route' => 'statistics'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link'));

        return $menu;
    }

    public function createUserMenu(array $options): ItemInterface
    {
        
        
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ');
        if ($user = $this->security->getUser()) {
            $menu->addChild('logout', ['route' => 'security_logout'])
                ->setAttributes(array('class' => 'nav-item'))
                ->setLinkAttributes(array('class'=> 'nav-link '));
        }
        else{
            $menu->addChild('login', ['route' => 'security_login'])
                    ->setAttributes(array('class' => 'nav-item'))
                    ->setLinkAttributes(array('class'=> 'nav-link bg-primary'));
            $menu->addChild('register', ['route' => 'security_registration'])
                    ->setAttributes(array('class' => 'nav-item'))
                    ->setLinkAttributes(array('class'=> 'nav-link '));
            }

        return $menu;
    }
}
?>