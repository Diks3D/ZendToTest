<?php

return array(
    'acl' => array(
        'roles' => array(
            'guest' => null,
            'user' => 'guest',
            'admin' => 'user',
        ),
        'resources' => array(
            'allow' => array(
                'Dashboard\Controller\Auth' => array(
                    'auth' => 'guest',
                    'adminauth' => 'guest',
                    'logout' => 'user',
                ),
                'Dashboard\Controller\Dashboard' => array(
                    'all' => 'user'
                ),
                'Dashboard\Controller\User' => array(
                    'all' => 'admin',
                ),
                'Application\Controller\Index' => array(
                    'all' => 'guest'
                ),
                'Money\Controller\Index' => array(
                    'all' => 'guest'
                ),
                'Money\Controller\YandexMoney' => array(
                    'all' => 'user'
                ),
            )
        )
    )
);