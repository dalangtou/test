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

    public function message1(Request $request)
    {
        $message = $request->input('info');
        $uid = $request->input('uid');

        $data['info'] = $message;

        SendToWork($data, $uid);

        return [200,'success'];
    }

    public function message()
    {
        $arg1 = 'first';
        $arg2 = 'two';
        $return = call_user_func(function(){
            $arg = func_get_arg(0); //func_get_arg函数作用：获取函数的第几个参数，必须要有参数，参数必须为函数参数的偏移量，0代表第一个参数
            $args = func_get_args();//func_get_args的作用：获取函数所有的参数
            if(func_num_args() == 1){//func_num_args函数的作用：获取函数参数的个数，注意，假如函数没有传参，该函数返回0
                return $args[0];
            }else{
                //用|把函数的参数组织成字符串
                return implode('|',$args);
            }
        },$arg1,$arg2);
        var_dump($return);
    }
}
