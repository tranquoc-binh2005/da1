<?php
return [
    'default' => [
        'generate_filename' => [
                'enabled' => true
            ]
        ,
        'optimize' => [
                'enabled' => true, 'quality' => 80
            ],
        'storage' => [
            'enabled' => true,
            'path' => 'public/uploads/images/',
            'disk' => 'local'
        ],
    ],
];
