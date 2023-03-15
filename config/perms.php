<?php
return [
    'products' => [
        'label' => 'Productos',
        'children' => [
            [
                'label' => 'Ver',
                'value' => 'products-view',
            ],
            [
                'label' => 'Listar',
                'value' => 'products-index',
            ],
            [
                'label' => 'Crear',
                'value' => 'products-store',
            ],
            [
                'label' => 'Actualizar',
                'value' => 'products-update',
            ],
            [
                'label' => 'Eliminar',
                'value' => 'products-delete',
            ],
        ]
    ],
    'roles-users' => [
        'label' => 'Roles de Usuario',
        'children' => [
            [
                'label' => 'Listar',
                'value' => 'roles-users-index'
            ],
            [
                'label' => 'Ver',
                'value' => 'roles-users-view'
            ],
            [
                'label' => 'Crear',
                'value' => 'roles-users-store'
            ],
            [
                'label' => 'Actualizar',
                'value' => 'roles-users-update'
            ],
            [
                'label' => 'Eliminar',
                'value' => 'roles-users-delete'
            ],
        ]
    ]
];