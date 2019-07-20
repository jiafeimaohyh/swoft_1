<?php

use App\Common\DbSelector;
use Swoft\Db\Pool;
use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Http\Server\Swoole\RequestListener;
use Swoft\WebSocket\Server\WebSocketServer;
use Swoft\Server\Swoole\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Redis\RedisDb;

return [
    'logger'         => [
        'flushRequest' => true,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer'     => [
        'class'    => HttpServer::class,
        'port'     => 9501,
        'listener' => [
            'rpc' => bean('rpcServer')
        ],
        'on'       => [
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => 3,
            'task_enable_coroutine' => true
        ]
    ],
    'httpDispatcher' => [
        // Add global http middleware
        'middlewares' => [
            // Allow use @View tag
            \Swoft\View\Middleware\ViewMiddleware::class,
            \App\Http\Middleware\SomeMiddleware::class,
        ],
    ],
    'db'             => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test;host=192.168.4.11',
        'username' => 'root',
        'password' => 'swoft123456',
    ],
    'db2'            => [
        'class'      => Database::class,
        'dsn'        => 'mysql:dbname=test2;host=192.168.4.11',
        'username'   => 'root',
        'password'   => 'swoft123456',
        'dbSelector' => bean(DbSelector::class)
    ],
    'db2.pool'       => [
        'class'    => Pool::class,
        'database' => bean('db2')
    ],
    'db3'            => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test2;host=192.168.4.11',
        'username' => 'root',
        'password' => 'swoft123456'
    ],
    'db3.pool'       => [
        'class'    => Pool::class,
        'database' => bean('db3')
    ],
    'migrationManager' => [
        'migrationPath' => '@app/Migration',
    ],
    'redis'          => [
        'class'    => RedisDb::class,
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
    ],
    'user'           => [
        'class'   => App\Rpc\Client\Client::class,
        //'class'   => ServiceClient::class,
        'host'    => '127.0.0.1',
        'serviceName'=>'user',
        'port'    => 9508,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'user.pool'      => [
        'class'  => ServicePool::class,
        'client' => bean('user')
    ],

    'pay'           => [
        'class'   => App\Rpc\Client\Client::class,
        //'class'   => ServiceClient::class,
        'host'    => '127.0.0.1',
        'serviceName'=>'pay',
        'port'    => 9508,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'pay.pool'      => [
        'class'  => ServicePool::class,
        'client' => bean('pay')
    ],


    'rpcServer'      => [
        'class' => ServiceServer::class,
        'port'  => 9508,
    ],
    'wsServer'       => [
        'class'   => WebSocketServer::class,
        'on'      => [
            // Enable http handle
            SwooleEvent::REQUEST => bean(RequestListener::class),
        ],
        'debug'   => env('SWOFT_DEBUG', 0),
        /* @see WebSocketServer::$setting */
        'setting' => [
            'log_file' => alias('@runtime/swoole.log'),
        ],
    ],
    'cliRouter'      => [
        // 'disabledGroups' => ['demo', 'test'],
    ]
];
