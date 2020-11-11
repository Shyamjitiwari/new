<?php

return [
    'role_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'user-groups' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'projects' => 'c,r,u,d',
            'leads' => 'c,r,u,d',
            'lead-statuses' => 'c,r,u,d',
            'lead-sources' => 'c,r,u,d',
            'lead-histories' => 'c,r,u,d',
            'comments' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'transfer-owner-leads' => 'c,r,u,d',
            'activities' => 'c,r,u,d',
            'locations'  => 'c,r,u,d',
            'project-units' => 'c,r,u,d',
            'builders'  => 'c,r,u,d',
            'reports' => 'c,r,u,d',
            'attendances' => 'c,r,u,d',
            'apis' => 'c,r,u,d',
        ],
        'admin' => [
            'project-units' => 'c,r,u,d',
            'projects' => 'c,r,u,d',
            'locations'  => 'c,r,u,d',
            'leads' => 'c,r,u,d',
            'lead-statuses' => 'c,r,u,d',
            'lead-sources' => 'c,r,u,d',
            'lead-histories' => 'c,r,u,d',
            'comments' => 'c,r,u,d',
            'builders' => 'c,r,u,d',
            'reports' => 'c,r,u,d',
            'attendances' => 'c,r,u,d',
            'apis' => 'c,r,u,d',
        ],
        'telecaller' => [
            'leads' => 'c,r,u',
            'lead-histories' => 'c,r,u',
            'comments' => 'c,r,u',
            'projects' => 'c,r',
            'locations'  => 'c,r',
            'project-units' => 'c,r',
            'builders'  => 'c,r',
            'reports' => 'r',
            'attendances' => 'c,r',

        ],
        'sales' => [
            'leads' => 'c,r,u',
            'lead-histories' => 'c,r,u',
            'comments' => 'c,r,u',
            'projects' => 'c,r',
            'locations'  => 'c,r',
            'project-units' => 'c,r',
            'builders' => 'c,r',
            'reports' => 'r',
            'attendances' => 'c,r',

        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
