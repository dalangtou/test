<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HookController extends Controller
{
    //
    public function test(Request $request)
    {
        
        $hook = new Hook();
        $hook->add('women',function($msg){
            echo '<br>'.'oh my god '.$msg ; 
        });
        $hook->add('man',function($msg){
            echo '<br>'.'nothing '.$msg ; 
        });

        // 执行
        $hook->excec('man','taoge');
        $hook->excec('women','xxx');
    }
}



class Hook{
	
    private  $hookList;
    
    //添加
    function add($name,$fun){
        $this->hookList[$name][] = $fun;
    }

    function excec($name){
        $value = func_get_args();
        unset($value[0]);
        foreach ($this->hookList[$name] as $key => $fun) {
            call_user_func_array($fun, $value);
        }
    }
}