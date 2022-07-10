<?php

$configList = [
    'URL_MODEL' => 2,
    'SESSION_OPTIONS'         =>  [
        'name'                =>  'jeff',                    //设置session名
        'expire'              =>  31536000,                      //SESSION过期时间，单位秒
        'use_trans_sid'       =>  1,                               //跨页传递
        'use_only_cookies'    =>  0,                               //是否只开启基于cookies的session的会话方式

    ],
    'DB_PARAMS' => [\PDO::ATTR_CASE => \PDO::CASE_NATURAL] //查询mysql字段默认转换小写改禁止转换
];

if (APP_ENV == 'local') {
    return array_merge($configList, [
        //'配置项'=>'配置值'
        // trace
        'SHOW_PAGE_TRACE' => true,
        'SHOW_RUN_TIME'    => true, // 运行时间显示
        'SHOW_ADV_TIME'    => true, // 显示详细的运行时间
        'SHOW_DB_TIMES'    => true, // 显示数据库查询和写入次数
        'SHOW_CACHE_TIMES' => true, // 显示缓存操作次数
        'SHOW_USE_MEM'     => true, // 显示内存开销
        'SHOW_LOAD_FILE'   => true, // 显示加载文件数
        'SHOW_FUN_TIMES'   => true, // 显示函数调用次数

        //mysql
        'db_type'  => 'mysql',
        'db_user'  => 'root',
        'db_pwd'   => '123456',
        'db_host'  => '10.10.21.47',
        'db_port'  => '3306',
        'db_name'  => 'sertmfdtvn25j83',
        'db_charset'=> 'utf8',
    ]);
} else {
    return array_merge($configList, [
        //'配置项'=>'配置值'
        'db_type'  => 'mysql',
        'db_user'  => 'fr3d_32110900',
        'db_pwd'   => 'asd123',
        'db_host'  => 'sql102.freeee.ml',
        'db_port'  => '3306',
        'db_name'  => 'fr3d_32110900_z',
        'db_charset'=> 'utf8',
    ]);
}

