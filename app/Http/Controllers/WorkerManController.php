<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Workerman\Worker;


class WorkerManController extends Controller
{
    public function start(Request $request)
    {
//        $path = app_path('vendor\Workerman\\');
//        require_once ($path.'Worker.php');

        // 创建一个Worker监听2346端口，使用websocket协议通讯
        $ws_worker = Worker::VERSION;
dd($ws_worker);
        // 启动4个进程对外提供服务
        $ws_worker->count = 4;

        // 当收到客户端发来的数据后返回hello $data给客户端
        $ws_worker->onMessage = function($connection, $data)
        {
            // 向客户端发送hello $data
            $connection->send('hello ' . $data);
        };

        // 运行
        Worker::runAll();
    }
}
