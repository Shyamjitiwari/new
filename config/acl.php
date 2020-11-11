<?php

return [
    'role_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'tags' => 'c,r,u,d',
            'blogs' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'activities' => 'c,r,u,d',
            'enquiries' => 'c,r,u,d',
            'galleries' => 'c,r,u,d',
            'pages' => 'c,r,u,d',
            'services' => 'c,r,u,d',
            'testimonials' => 'c,r,u,d',
            'sliders' => 'c,r,u,d',
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'tags' => 'c,r,u,d',
            'blogs' => 'c,r,u,d',
            'activities' => 'c,r,u,d',
            'enquiries' => 'c,r,u,d',
            'galleries' => 'c,r,u,d',
            'pages' => 'c,r,u,d',
            'services' => 'c,r,u,d',
            'testimonials' => 'c,r,u,d',
            'sliders' => 'c,r,u,d',
        ],
        'author' => [
            'categories' => 'c,r',
            'tags' => 'c,r',
            'blogs' => 'c,r,u',
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
