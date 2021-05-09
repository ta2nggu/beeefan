<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
//        'superadministrator' => [
//            'users' => 'c,r,u,d',
//            'payments' => 'c,r,u,d',
//            'profile' => 'r,u'
//        ],
//        'administrator' => [
//            'users' => 'c,r,u,d',
//            'profile' => 'r,u'
//        ],
        //21.05.08 김태영, superadministrator 추가
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        //21.02.21 김태영, creator 추가, administrotr 권한 추가, superadmin 제거
        'administrator' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'creator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'user' => [
            'profile' => 'r,u',
        ],
        'role_name' => [
            'module_1_name' => 'c,r,u,d',
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
