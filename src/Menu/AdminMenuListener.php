<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('stock-management',)
            ->setLabel('Stock Management');


        $newSubmenu
            ->addChild('stock-management-stocks', ['route' => 'sylius_admin/stock_product_variant_index'])
            ->setLabel('Stockables');

        $newSubmenu
            ->addChild('stock-management-suppliers', ['route' => 'app_admin/stock_supplier_index'])
            ->setLabel('Suppliers');

        $newSubmenu
            ->addChild('stock-management-puchase-order', ['route' => 'app_admin/stock_purchase_order_index'])
            ->setLabel('Purchase Orders');
    }
}
