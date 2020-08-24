<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;


class WorkerManController extends Controller
{

    //废弃  console 中开启
//    public function start(Request $request)
//    {
////        $path = app_path('vendor\Workerman\\');
////        require_once ($path.'Worker.php');
//
//        // 创建一个Worker监听2346端口，使用websocket协议通讯
//        $ws_worker = Worker::VERSION;
//dd($ws_worker);
//        // 启动4个进程对外提供服务
//        $ws_worker->count = 4;
//
//        // 当收到客户端发来的数据后返回hello $data给客户端
//        $ws_worker->onMessage = function($connection, $data)
//        {
//            // 向客户端发送hello $data
//            $connection->send('hello ' . $data);
//        };
//
//        // 运行
//        Worker::runAll();
//    }

    public function message(Request $request)
    {
        $message = $request->input('info');
        $uid = $request->input('uid');

// 建立socket连接到内部推送端口
        $client = stream_socket_client('tcp://127.0.0.1:5678', $errno, $errmsg, 1);
// 推送的数据，包含uid字段，表示是给这个uid推送
        $data = array('percent'=>'88%');
        if($uid) $data['uid'] = $uid;
// 发送数据，注意5678端口是Text协议的端口，Text协议需要在数据末尾加上换行符
        fwrite($client, json_encode($data)."\n");
// 读取推送结果
        echo fread($client, 8192);

        return [200,'success'];
    }
}
