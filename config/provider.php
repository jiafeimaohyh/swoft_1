<?php

return [
    'consul' => [
        'address' => '47.106.113.190', //consul的地址
        'port'    => 8500,
        'register' => [
            'ID'                =>'pay',
            'Name'              =>'pay-php',
            'Tags'              =>['primary'],
            'Address'           =>'47.106.113.190',
            'Port'              =>9501,
            'Check'             => [
                'tcp'      => '47.106.113.190:9501',
                'interval' => '5s',
                'timeout'  => '2s',
            ]
        ],
        'discovery' => [
            'name' => 'user',
            'dc' => 'dc',
            'passing' => true
        ]
    ],
];