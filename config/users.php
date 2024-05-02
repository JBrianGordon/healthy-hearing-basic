<?php

$config = [
    'Users' => [
        // Table used to manage users
        'table' => 'Users',
        // Controller used to manage users plugin features & actions
        'controller' => 'CakeDC/Users.Users',
        'Registration' => [
            // determines if the register is enabled
            'active' => false,
        ],
        'Profile' => [
            // Allow view other users profiles
            'viewOthers' => false,
        ],
    ],
    'Auth' => [
        'Identifiers' => [
            'Password' => [
                'className' => 'Authentication.Password',
                'fields' => [
                    'username' => ['username', 'email'],
                    'password' => 'password',
                ],
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'finder' => ['auth'],
                ],
            ],
        ],
    ],
];

return $config;
