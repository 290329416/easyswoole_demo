<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
    'SERVER_NAME'    => "EasySwoole",
    'MAIN_SERVER'    => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT'           => 9501,
        'SERVER_TYPE'    => EASYSWOOLE_WEB_SOCKET_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE'      => SWOOLE_TCP,
        'RUN_MODEL'      => SWOOLE_PROCESS,
        'SETTING'        => [
            'worker_num'            => 8,
            'reload_async'          => true,
            'max_wait_time'         => 5,
            'document_root'         => EASYSWOOLE_ROOT . '/Static',
            'enable_static_handler' => true,
            'heartbeat_idle_time'      => 300, // 表示一个连接如果300秒内未向服务器发送任何数据，此连接将被强制关闭
            'heartbeat_check_interval' => 60,  // 表示每60秒遍历一次
        ],
        'TASK'           => [
            'workerNum' => 4, 'maxRunningNum' => 128, 'timeout' => 15
        ]
    ],
    'TEMP_DIR'       => null,
    'LOG_DIR'        => null,
    'CONSOLE'        => [
        'ENABLE'         => true,
        'LISTEN_ADDRESS' => '127.0.0.1',
        'HOST'           => '127.0.0.1',
        'PORT'           => 9500,
        'USER'           => 'root',
        'PASSWORD'       => '123456'
    ],
    'DISPLAY_ERROR'  => true,
    'PHAR'           => [
        'EXCLUDE' => ['.idea', 'Log', 'Temp', 'easyswoole', 'easyswoole.install']
    ],

    // 当前的域名
    'HOST'           => 'http://127.0.0.1:9501',
    'WEBSOCKET_HOST' => 'ws://127.0.0.1:9501',


    'CHECK_EMAIL'   => true,
    'EMAIL_SETTING' => [
        'PORT'     => 465,
        'FORM'     => 'EASY-DEMO <mipone@foxmail.com>',
        'SERVER'   => 'smtp.qq.com',
        'SECURE'   => true,
        'USERNAME' => 'mipone@foxmail.com',
        'PASSWORD' => 'abltlnhpmdyfbcga',
    ]
];
