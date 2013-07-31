<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Dashboard\Controller\User' => 'Dashboard\Controller\UserController',
            'Dashboard\Controller\Auth' => 'Dashboard\Controller\AuthController',
            'Dashboard\Controller\Dashboard' => 'Dashboard\Controller\DashboardController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dashboard' => array(
                'type' => 'literal',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        'controller' => 'Dashboard\Controller\Dashboard',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'user' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/user[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Dashboard\Controller\User',
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
                                'controller' => 'Dashboard\Controller\Dashboard',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            'userauth' => array(
                'type' => 'literal',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/dashboard/auth',
                    'defaults' => array(
                        'controller' => 'Dashboard\Controller\Auth',
                        'action' => 'auth',
                    ),
                ),
            ),
            'adminauth' => array(
                'type' => 'literal',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/dashboard/admin',
                    'defaults' => array(
                        'controller' => 'Dashboard\Controller\Auth',
                        'action' => 'adminauth',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'literal',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/dashboard/logout',
                    'defaults' => array(
                        'controller' => 'Dashboard\Controller\Auth',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'dashboard/layout' => __DIR__ . '/../view/layout/dashboard.phtml',
        ),
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
            'dashboard' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'dashboard_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Dashboard/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Dashboard\Entity' => 'dashboard_entities'
                )
            )
        )
    )
);