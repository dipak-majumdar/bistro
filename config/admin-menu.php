<?php

return [
    'items' => [
        [
            'priority' => 10,
            'type' => 'link',
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'airplay',
        ],
        [
            'priority' => 11,
            'type' => 'link',
            'label' => 'Order Management',
            'route' => 'admin.orders',
            'icon' => 'grid-3x3',
        ],
        [
            'priority' => 20,
            'type' => 'accordion',
            'label' => 'Item Menu',
            'icon' => 'component',
            'children' => [
                [
                    'priority' => 1,
                    'type' => 'link',
                    'label' => 'Categories',
                    'route' => 'admin.item-category',
                ],
                [
                    'priority' => 2,
                    'type' => 'link',
                    'label' => 'Variation Types',
                    'route' => 'admin.item-variation-types',
                ],
                [
                    'priority' => 3,
                    'type' => 'link',
                    'label' => 'GST Slabs',
                    'route' => 'admin.gst-slabs',
                ],
                [
                    'priority' => 4,
                    'type' => 'link',
                    'label' => 'Menu Items',
                    'route' => 'admin.menu-items',
                ],
            ],
        ],
        [
            'priority' => 40,
            'type' => 'link',
            'label' => 'Customers',
            'route' => 'admin.customers',
            'icon' => 'grid-3x3',
        ],
        [
            'priority' => 41,
            'type' => 'accordion',
            'label' => 'Home Layout',
            'icon' => 'grid-3x3',
            'children' => [
                [
                    'priority' => 1,
                    'type' => 'link',
                    'label' => 'Components',
                    'route' => 'admin.home-component'
                ],
                [
                    'priority' => 2,
                    'type' => 'link',
                    'label' => 'Component Order',
                    'route' => 'admin.component-orders',
                ],
            ]
        ],
        [
            'priority' => 100,
            'type' => 'divider',
            'label' => 'Elements',
        ],
        [
            'priority' => 110,
            'type' => 'accordion',
            'label' => 'Components',
            'icon' => 'component',
            'children' => [
                [
                    'priority' => 1,
                    'type' => 'link',
                    'label' => 'Accordion',
                    'url' => 'ui-accordion.html',
                ],
                [
                    'priority' => 2,
                    'type' => 'link',
                    'label' => 'Alert',
                    'url' => 'ui-alerts.html',
                ],
                [
                    'priority' => 3,
                    'type' => 'link',
                    'label' => 'Avatars',
                    'url' => 'ui-avatars.html',
                ],
                [
                    'priority' => 4,
                    'type' => 'link',
                    'label' => 'Buttons',
                    'url' => 'ui-buttons.html',
                ],
                [
                    'priority' => 5,
                    'type' => 'link',
                    'label' => 'Badges',
                    'url' => 'ui-badges.html',
                ],
                [
                    'priority' => 6,
                    'type' => 'link',
                    'label' => 'Breadcrumbs',
                    'url' => 'ui-breadcrumbs.html',
                ],
                [
                    'priority' => 7,
                    'type' => 'link',
                    'label' => 'Cards',
                    'url' => 'ui-cards.html',
                ],
                [
                    'priority' => 8,
                    'type' => 'link',
                    'label' => 'Collapse',
                    'url' => 'ui-collapse.html',
                ],
                [
                    'priority' => 9,
                    'type' => 'link',
                    'label' => 'Dropdowns',
                    'url' => 'ui-dropdowns.html',
                ],
                [
                    'priority' => 10,
                    'type' => 'link',
                    'label' => 'Progress',
                    'url' => 'ui-progress.html',
                ],
                [
                    'priority' => 11,
                    'type' => 'link',
                    'label' => 'Spinners',
                    'url' => 'ui-spinners.html',
                ],
                [
                    'priority' => 12,
                    'type' => 'link',
                    'label' => 'Skeleton',
                    'url' => 'ui-skeleton.html',
                ],
                [
                    'priority' => 13,
                    'type' => 'link',
                    'label' => 'Ratio',
                    'url' => 'ui-ratio.html',
                ],
                [
                    'priority' => 14,
                    'type' => 'link',
                    'label' => 'Modals',
                    'url' => 'ui-modals.html',
                ],
                [
                    'priority' => 15,
                    'type' => 'link',
                    'label' => 'Offcanvas',
                    'url' => 'ui-offcanvas.html',
                ],
                [
                    'priority' => 16,
                    'type' => 'link',
                    'label' => 'Popovers',
                    'url' => 'ui-popovers.html',
                ],
                [
                    'priority' => 17,
                    'type' => 'link',
                    'label' => 'Tooltips',
                    'url' => 'ui-tooltips.html',
                ],
                [
                    'priority' => 18,
                    'type' => 'link',
                    'label' => 'Typography',
                    'url' => 'ui-typography.html',
                ],
            ],
        ],
        [
            'priority' => 120,
            'type' => 'accordion',
            'label' => 'Forms',
            'icon' => 'notebook-pen',
            'children' => [
                [
                    'priority' => 1,
                    'type' => 'link',
                    'label' => 'Inputs',
                    'url' => 'forms-inputs.html',
                ],
                [
                    'priority' => 2,
                    'type' => 'link',
                    'label' => 'Checkbox & Radio',
                    'url' => 'forms-check-radio.html',
                ],
                [
                    'priority' => 3,
                    'type' => 'link',
                    'label' => 'Input Masks',
                    'url' => 'forms-masks.html',
                ],
                [
                    'priority' => 4,
                    'type' => 'link',
                    'label' => 'Editor',
                    'url' => 'forms-editor.html',
                ],
                [
                    'priority' => 5,
                    'type' => 'link',
                    'label' => 'Validation',
                    'url' => 'forms-validation.html',
                ],
                [
                    'priority' => 6,
                    'type' => 'link',
                    'label' => 'Form Layout',
                    'url' => 'forms-layout.html',
                ],
            ],
        ],
        [
            'priority' => 130,
            'type' => 'link',
            'label' => 'Maps',
            'url' => 'maps-vector.html',
            'icon' => 'map',
        ],
        [
            'priority' => 140,
            'type' => 'link',
            'label' => 'Tables',
            'url' => 'tables-basic.html',
            'icon' => 'grid-3x3',
        ],
        [
            'priority' => 150,
            'type' => 'link',
            'label' => 'Chart',
            'url' => 'charts-apex.html',
            'icon' => 'chart-pie',
        ],
        [
            'priority' => 160,
            'type' => 'link',
            'label' => 'Icons',
            'url' => 'icons.html',
            'icon' => 'dribbble',
        ],
        [
            'priority' => 170,
            'type' => 'accordion',
            'label' => 'Level',
            'icon' => 'align-left',
            'children' => [
                [
                    'priority' => 1,
                    'type' => 'link',
                    'label' => 'Item 1',
                    'url' => 'javascript: void(0)',
                ],
                [
                    'priority' => 2,
                    'type' => 'link',
                    'label' => 'Item 2',
                    'url' => 'javascript: void(0)',
                ],
            ],
        ],
        [
            'priority' => 180,
            'type' => 'link',
            'label' => 'Badge Items',
            'url' => 'javascript:void(0)',
            'icon' => 'badge-check',
            'badge' => [
                'text' => 'Hot',
                'class' => 'bg-gray-800 text-white',
            ],
        ],
    ],
];

