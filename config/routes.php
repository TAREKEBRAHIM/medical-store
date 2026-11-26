<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', [
            'controller' => 'Pages',
            'action' => 'display',
            'home',
    
            ]);
        $builder->connect('/login', [
            'controller' => 'Users',
            'action' => 'login',
        ]);
        $builder->connect('/register', [
            'controller' => 'Users',
            'action' => 'register',
        ]);
        $builder->connect('/users/logout', [
            'controller' => 'Users',
            'action' => 'logout',
        ]);

        $builder->connect('/products', [
            'prefix' => 'Customer',
            'controller' => 'Products',
            'action' => 'index',
        ]);

        $builder->connect('/products/add-to-cart/{id}', [
            'prefix' => 'Customer',
            'controller' => 'Products',
            'action' => 'addToCart',
        ])->setPass(['id']);
     
        $builder->connect('/products/view/{id}', [
            'prefix' => 'Customer',
            'controller' => 'Products',
            'action' => 'view',
        ])->setPass(['id']);

        $builder->connect('/cart', [
            'prefix' => 'Customer',
            'controller' => 'Cart',
            'action' => 'index',
        ]);

        $builder->connect('/cart/update/{id}', [
            'prefix' => 'Customer',
            'controller' => 'Cart',
            'action' => 'update',
        ])->setPass(['id']);
      
        $builder->connect('/cart/remove/{id}', [
            'prefix' => 'Customer',
            'controller' => 'Cart',
            'action' => 'remove',
        ])->setPass(['id']);
       
        $builder->connect('/cart/checkout', [
            'prefix' => 'Customer',
            'controller' => 'Cart',
            'action' => 'checkout',
        ]);

        $builder->connect('/cart/confirmation/{id}', [
            'prefix' => 'Customer',
            'controller' => 'Cart',
            'action' => 'confirmation',
        ])->setPass(['id']);

        $builder->connect('/my-orders', [
            'prefix' => 'Customer',
            'controller' => 'Orders',
            'action' => 'index',
        ]);
        $builder->connect('/my-orders/{id}', [
            'prefix' => 'Customer',
            'controller' => 'Orders',
            'action' => 'view',
        ])->setPass(['id']);

        $builder->prefix('Admin', function (RouteBuilder $admin): void {
            $admin->connect('/products', [
                'controller' => 'Products',
                'action' => 'index',
            ]);
            $admin->fallbacks(DashedRoute::class);
        });

        $builder->prefix('Customer', function (RouteBuilder $customer): void {
            $customer->connect('/products', [
                'controller' => 'Products',
                'action' => 'index',
            ], ['_name' => 'customerProducts']);
            $customer->connect('/products/add-to-cart/{id}', [
                'controller' => 'Products',
                'action' => 'addToCart',
            ], ['_name' => 'customerAddToCart'])->setPass(['id']);
            $customer->connect('/products/view/{id}', [
                'controller' => 'Products',
                'action' => 'view',
            ], ['_name' => 'customerProductView'])->setPass(['id']);
            $customer->connect('/cart', [
                'controller' => 'Cart',
                'action' => 'index',
            ], ['_name' => 'customerCart']);
            $customer->connect('/cart/update/{id}', [
                'controller' => 'Cart',
                'action' => 'update',
            ], ['_name' => 'customerCartUpdate'])->setPass(['id']);
            $customer->connect('/cart/remove/{id}', [
                'controller' => 'Cart',
                'action' => 'remove',
            ], ['_name' => 'customerCartRemove'])->setPass(['id']);
            $customer->connect('/cart/checkout', [
                'controller' => 'Cart',
                'action' => 'checkout',
            ], ['_name' => 'customerCheckout']);
            $customer->connect('/cart/confirmation/{id}', [
                'controller' => 'Cart',
                'action' => 'confirmation',
            ], ['_name' => 'customerOrderConfirmation'])->setPass(['id']);
            $customer->connect('/orders', [
                'controller' => 'Orders',
                'action' => 'index',
            ], ['_name' => 'customerOrders']);
            $customer->connect('/orders/{id}', [
                'controller' => 'Orders',
                'action' => 'view',
            ], ['_name' => 'customerOrderView'])->setPass(['id']);
            $customer->fallbacks(DashedRoute::class);
        });

        $builder->fallbacks(DashedRoute::class);
    });
};
