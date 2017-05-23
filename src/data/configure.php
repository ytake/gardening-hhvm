<?php

/**
 * Gardening Configure
 * for vagrant configuration file
 */
return [
    'ip' => "192.168.10.10",
    'memory' => 2048,
    'cpus' => 1,
    'hostname' => 'gardening-hhvm',
    'name' => 'gardening-hhvm',
    'authorize' => '~/.ssh/id_rsa.pub',
    'keys' => [
        '~/.ssh/id_rsa',
    ],
    'folders' => [
        [
            'map' => null,
            'to' => '/home/vagrant/Code'
        ]
    ],
    'sites' => [
        [
            'map' => 'gardening-hhvm.app',
            'to' => '/home/vagrant/Code/public',
        ]
    ],
];
