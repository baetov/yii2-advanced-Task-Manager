<?php
return [
    'createProject' => [
        'type' => 2,
        'description' => 'Create a project',
    ],
    'user' => [
        'type' => 1,
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'createProject',
        ],
    ],
];
