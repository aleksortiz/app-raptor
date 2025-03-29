<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => env('APP_FULL_NAME', 'APP_FULL_NAME'),
    'title_prefix' => '',
    'title_postfix' => ' | ' . env('APP_INITIALS', 'AOS'),

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>' . env('APP_FULL_NAME', 'APP_FULL_NAME') .    '</b>',
    'logo_img' => 'images/logoshort.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => env('APP_FULL_NAME', 'APP_FULL_NAME'),

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-secondary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => false,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'bg-gradient-dark',
    'classes_auth_header' => '',
    'classes_auth_body' => 'bg-gradient-dark',
    'classes_auth_footer' => 'text-center',
    'classes_auth_icon' => 'fa-fw text-light',
    'classes_auth_btn' => 'btn-flat btn-light',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => 'container-fluid',
    'classes_sidebar' => 'sidebar-dark-secondary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => true,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // [
        //     'type' => 'navbar-search',
        //     'text' => 'Folio de Entrada',
        //     'topnav_right' => true,
        // ],
        [
            'type' => 'sidebar-custom-search',
            'text' => 'Buscar Entrada',                // Placeholder for the underlying input.
            'url' => 'servicios/busqueda',         // The url used to submit the data ('#' by default).
            'method' => 'get',                // 'get' or 'post' ('get' by default).
            'input_name' => 'folio',       // Name for the underlying input ('adminlteSearch' by default).
        ],
        [
            'text' => 'Servicios',
            'icon' => 'fas fa-fw fa-car',
            'url' => '/servicios',
            'topnav' => true,
        ],
        [
            'text' => 'Ordenes de Trabajo',
            'icon' => 'fas fa-fw fa-file-alt',
            'url' => '/personal/ordenes-trabajo',
            'topnav' => true,
        ],
        [
            'text' => 'Vehículos',
            'icon' => 'fas fa-fw fa-car',
            'url'    => '/vehiculos',
            'topnav' => true,
            'can' => ['venta-vehiculos'],
        ],
        [
          'text' => 'Vales de Materiales',
          'icon' => 'fas fa-fw fa-ticket-alt',
          'url' => '/materiales/vales',
          'topnav' => true,
        ],
        [
            'type'         => 'darkmode-widget',
            'topnav_right' => true,
        ],

        // [
        //     'text' => 'Mi cuenta',
        //     'icon' => 'fas fa-fw fa-cog',
        //     'url'  => '/compras/monitor',
        //     'topnav_right' => true,
        // ],
        [
            'text' => 'Inicio',
            'icon' => 'fas fa-fw fa-home',
            'route' => 'home'
        ],
        [
            'text' => 'Valuaciones',
            'icon' => 'fas fa-fw fa-file-alt',
            'submenu' => [
              [
                'text' => 'Ver valuaciones',
                'icon'   => 'fas fa-fw fa-chevron-right',
                'url' => '/valuaciones',
              ],
            //   [
            //     'text' => 'Calendario de valuaciones',
            //     'icon'   => 'fas fa-fw fa-chevron-right',
            //     'url' => '/valuaciones/calendario-valuaciones',
            //   ]
            ]
        ],
        [
            'text' => 'Negocio',
            'icon' => 'fas fa-fw fa-building',
            'can' => ['reporte-finanzas', 'reporte-facturas', 'reporte-depositos', 'gastos-generales', 'gastos-fijos'],
            'submenu' => [
                [
                    'text' => 'Reporte Finanzas',
                    'can' => ['reporte-finanzas'],
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url' => '/reporte-finanzas',
                ],
                [
                    'text' => 'Control de Facturación',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url' => '/control-facturacion',
                    'can' => ['reporte-facturas'],
                ],
                // [
                //     'text' => 'Reporte de Facturas',
                //     'icon'   => 'fas fa-fw fa-chevron-right',
                //     'url' => '/control-facturas',
                //     'can' => ['reporte-facturas'],
                // ],
                [
                    'text' => 'Depósitos',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url' => '/ingresos',
                    'can' => ['reporte-depositos'],
                ],
                [
                    'text' => 'Gastos Generales',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url' => '/egresos',
                    'can' => ['gastos-generales'],
                ],
                [
                    'text' => 'Gastos Fijos',
                    'can' => ['gastos-fijos'],
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/gastos-fijos',
                ]
            ]
        ],
        [
            'text' => 'Servicios',
            'icon' => 'fas fa-fw fa-car',
            'submenu' => [
                [
                    'text' => 'Registrar Entrada',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/crear-entrada',
                    'can' => ['registrar-entrada'],
                ],
                [
                    'text' => 'Catalogo de Entradas',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/servicios',
                    'can' => ['administrar-entradas'],
                ],
                [
                    'text' => 'Citas para reparación',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/citas-reparacion',
                ],
                [
                    'text' => 'Inventarios de Ingreso',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/inventarios',
                ],
                [
                    'text' => 'Vehiculos Entregados',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/vehiculos-entregados',
                    'can' => ['vehiculos-entregados'],
                ]
            ]
        ],
        [
            'text' => 'Registros QR',
            'icon' => 'fas fa-fw fa-qrcode',
            'url'    => '/clientes/registros-qr',
        ],
        [
            'text' => 'Calendario de Citas',
            'icon' => 'fas fa-fw fa-calendar-alt',
            'url'    => '/calendario-citas',
        ],
        [
            'text' => 'Clientes',
            'icon' => 'fas fa-fw fa-users',
            'url'    => '/clientes',
            'can' => ['administrar-clientes'],
        ],
        [
            'text' => 'Vehículos',
            'icon' => 'fas fa-fw fa-car',
            'url'    => '/vehiculos',
            'can' => ['venta-vehiculos'],
        ],
        [
            'text' => 'Materiales',
            'icon' => 'fas fa-fw fa-cubes',
            'can' => ['administrar-materiales', 'ver-materiales'],
            'submenu' => [
                [
                    'text'   => 'Almacen de Materiales',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/materiales',
                ],
                [
                  'text'   => 'Vale de Materiales',
                  'icon'   => 'fas fa-fw fa-chevron-right',
                  'url'    => '/materiales/vales',
                ],
                [
                    'text'   => 'Pedidos de Materiales',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/materiales/pedidos',
                ],
                [
                    'text'   => 'Bitacora de Materiales',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/materiales/bitacora',
                ],
                [
                    'text'   => 'Proveedores',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/proveedores',
                    'can' => ['administrar-proveedores', 'ver-proveedores'],
                ],
                // [
                //     'text'   => 'Pagos a Proveedoress',
                //     'icon'   => 'fas fa-fw fa-chevron-right',
                //     'url'    => '/proveedores/pagos',
                //     'can' => ['administrar-proveedores', 'ver-proveedores'],
                // ],
            ]
        ],
        [
            'text' => 'Personal',
            'icon' => 'fas fa-fw fa-user-tie',
            // 'can' => ['administrar-personal', 'diagrama-nomina'],
            'submenu' => [
                [
                    'text' => 'Catalogo de Personal',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/personal',
                    'can' => ['administrar-personal'],
                ],
                [
                    'text' => 'Diagrama Nomina',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/personal/diagrama-nomina',
                    'can' => ['diagrama-nomina'],
                ],
                [
                    'text' => 'Prestamos',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/personal/prestamos',
                    'can' => ['diagrama-nomina'],
                ],
                [
                    'text' => 'Ordenes de Trabajo',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/personal/ordenes-trabajo',
                ],
            ]
        ],
        [
            'text' => 'Refacciones',
            'icon' => 'fas fa-fw fa-wrench',
            'submenu' => [
                [
                    'text' => 'Catalogo de Refacciones',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'url'  => '/refacciones',
                ],
            ]
        ],
        [
            'text' => 'Servicio a flotillas',
            'icon' => 'fas fa-fw fa-taxi',
            'can' => ['servicio-flotillas'],
            'submenu' => [
                [
                    'text' => 'Flotillas',
                    'icon' => 'fas fa-fw fa-chevron-right',
                    'url'  => '/servicio-flotillas',
                ],
            ]
        ],
        [
            'text' => 'Catalogos',
            'icon' => 'fas fa-fw fa-book',
            'can' => ['administrar-catalogos'],
            'submenu' => [
                [
                    'text'   => 'Fabricantes',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/fabricantes',
                ],
                // [
                //     'text'   => 'Marcas',
                //     'icon'   => 'fas fa-fw fa-chevron-right',
                //     'url'    => '/marcas',
                // ],
                [
                    'text'   => 'Aseguradoras',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/aseguradoras',
                ],
            ]
        ],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users-cog',
            'can' => ['administrar-usuarios', 'administrar-privilegios'],
            'submenu' => [
                [
                    'text'   => 'Ver Usuarios',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'    => '/usuarios',
                    'can' => ['administrar-usuarios'],
                ],
                [
                    'text'   => 'Roles y Permisos',
                    'icon'   => 'fas fa-fw fa-chevron-right',
                    'url'  => '/usuarios/roles-permisos',
                    'can' => ['administrar-permisos'],
                ],
            ]
        ],
        // [
        //     'text' => 'Manuales de Usuario',
        //     'icon' => 'fas fa-fw fa-file',
        //     'url'  => '/manuales',
        // ],
        // [
        //     'text' => 'Soporte AOS',
        //     'icon' => 'fas fa-fw fa-code',
        //     'url'  => '/aos/tickets-soporte',
        //     'can' => ['tickets-soporte'],
        // ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        // App\Adminlte\menu_filters\RentAlertFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => '',
            'title' => '',
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => false,
            'scroll_right' => false,
            'fullscreen' => false,
        ],
        'options' => [
            'loading_screen' => 0,
            'auto_show_new_tab' => false,
            'use_navbar_items' => false,
            'auto_iframe_mode' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
