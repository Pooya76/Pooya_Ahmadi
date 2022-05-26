<?php

namespace App\Menu;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;
    private EntityManagerInterface $entityManager;

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory, EntityManagerInterface $entityManager)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'app_home']);
        $menu->addChild('About us', ['route' => 'app_about']);
        $menu->addChild('Contact us', ['route' => 'app_contact_us']);
        $hotelMenu = $menu->addChild('Hotels', ['route' => 'app_hotel_show']);
        $hotels = $this->entityManager->getRepository(Hotel::class)->findAll();

        foreach ($hotels as $hotel){
            $hotelMenu->addChild($hotel->getName(), ['route' => 'app_hotel_detail', 'routeParameters' => ['id'=>$hotel->getId()]]);
        }

        // ... add more children

        return $menu;
    }
}