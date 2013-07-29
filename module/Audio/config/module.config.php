<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Audio\Controller\Audio' => 'Audio\Controller\AudioController',
            'Audio\Controller\Upload' => 'Audio\Controller\UploadController',
            'Audio\Controller\Message' => 'Audio\Controller\MessageController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'audio' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/audio[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Audio\Controller\Audio',
                        'action' => 'index',
                    ),
                ),
            ),
            'storage' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/storage[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Audio\Controller\Upload',
                        'action' => 'index',
                    ),
                ),
            ),
            'success' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/success',
                    'defaults' => array(
                        'controller' => 'Audio\Controller\Message',
                        'action' => 'success',
                    ),
                ),
            ),
            'unsuccess' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/unsuccess',
                    'defaults' => array(
                        'controller' => 'Audio\Controller\Message',
                        'action' => 'unsuccess',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'audio' => __DIR__ . '/../view',
            'upload' => __DIR__ . '/../view',
            'message' => __DIR__ . '/../view',
        ),
    ),
);