<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Pusher\Pusher;

class PusherController extends Controller
{
    public function test(Request $request)
    {
        $app_id = env('PUSHER_APP_ID');
        $app_key = env('PUSHER_APP_KEY');
        $app_secret = env('PUSHER_APP_SECRET');
        $app_cluster = env('PUSHER_APP_CLUSTER');//

        $pusher = new Pusher( $app_key, $app_secret, $app_id,  array('cluster' => $app_cluster,'encrypted' => true));

        $data['message'] = 'hello !!! ';
        $pusher->trigger('my-channel', 'PusherEvent', $data);

//        $response = $pusher->get( '/channels/my-channel/PusherEvent' );//失败

//        $pusher->trigger( 'my-channel', 'my_event', 'hello world2222s' );
//        $pusher->trigger( [ 'channel-1', 'channel-2' ], 'my_event', 'hello world');

//
//        $batch = array();
//        $batch[] = array('channel' => 'my-channel', 'name' => 'my_event', 'data' => array('hello' => 'world'));
//        $batch[] = array('channel' => 'my-channel', 'name' => 'my_event', 'data' => array('myname' => 'bob'));
//        $batch[] = array('channel' => 'my-channel', 'name' => 'my_event', 'data' => array('myname' => 'sam'));
//        $pusher->triggerBatch($batch);

//        $pusher->socket_auth('private-my-channel','A111.222z');

//        $pusher->set_logger( new MyLogger() );

//        event(new \App\Events\Pusher('测试'));

        dd($pusher);
    }

    public function web_code()
    {
        $str = <<<'ETO'
            <!DOCTYPE html>
            <head>
            <title>Pusher Test</title>
            <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
            <script>
            
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;
            
                var pusher = new Pusher('462bd16697e1a61c30f6', {
                cluster: 'ap1',
                encrypted: true
                });
            
                // alert('hello !');
            
                var channel = pusher.subscribe('my-channel');
                console.log(pusher);
                channel.bind('PusherEvent', function(data) {
                alert(data.message);
                });
            </script>
            </head>
        ETO;
    }
}
