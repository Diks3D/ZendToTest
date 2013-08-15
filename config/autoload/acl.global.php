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
                )
            )
        )
    )
);