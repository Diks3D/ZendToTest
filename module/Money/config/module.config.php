<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Money\Controller\Index' => 'Money\Controller\IndexController',
            'Money\Controller\YandexMoney' => 'Money\Controller\YandexMoneyController',
            'Money\Controller\PayPal' => 'Money\Controller\PayPalController',
            'Money\Controller\WebMoney' => 'Money\Controller\WebMoneyController',
            'Money\Controller\MoneyBookers' => 'Money\Controller\MoneyBookersController',
            'Money\Controller\Qiwi' => 'Money\Controller\QiwiController',
            'Money\Controller\RoboKassa' => 'Money\Controller\RoboKassaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'money' => array(
                'type' => 'literal',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/money',
                    'defaults' => array(
                        'controller' => 'Money\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'yandexmoney' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/yandexmoney[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Money\Controller\YandexMoney',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'messages' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/messages[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Money\Controller\Money',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'money/layout' => __DIR__ . '/../view/layout/money.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);