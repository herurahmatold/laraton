<?php

$menu_admin=[
    'Manage User'=>[
        's1'=>'core',
        's2'=>'users',
        'icon'=>'fa fa-users',
        'child'=>[
            'User Groups'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.users.group'
            ],
            'Users'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.users.user'
            ]
        ]
    ]
];

$menu_config=[
    'Configuration'=>[
        's1'=>'core',
        's2'=>'config',
        'icon'=>'fa fa-wrench',
        'child'=>[
            'Application'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.users.group'
            ],
            'Company'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.users.user'
            ],
            'Logo & Favicon'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.users.user'
            ],
        ]
    ]
];

return array_merge($menu_admin,$menu_config);