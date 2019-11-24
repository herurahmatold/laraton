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
                'route'=>'core.config.general',
                'params'=>['prefix'=>'app']
            ],
            'Company'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.config.general',
                'params'=>['prefix'=>'company']
            ],
            'Logo & Favicon'=>[
                'icon'=>'fa fa-circle-o',
                'route'=>'core.config.logo'
            ],
        ]
    ]
];

return array_merge($menu_admin,$menu_config);

/*
Jika menu sama dengan role akses lainnya, pada role navigation file tambahkan
$menu = include('superadmin.php');
return $menu;
*/