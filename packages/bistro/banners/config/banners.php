<?php

return [
    'default_position' => 'home',
    'positions' => ['home', 'category', 'product'],
    'image_sizes' => [
        'desktop' => ['width' => 1920, 'height' => 600],
        'mobile' => ['width' => 768, 'height' => 400],
    ],
    'max_file_size' => 2048, // KB
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
    'cache_minutes' => 60,
];
