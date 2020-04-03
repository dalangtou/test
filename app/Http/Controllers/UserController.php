<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\UserBase;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	dd(312312321);
        //
        $uid = 1;
        $info = UserBase::find($uid);
        // $info = $info->load('garage');
        dump($info->toarray());
    }

    public function JWT()
    {
        $builder = new Builder();
        $signer  = new Sha256();

        $secret = "XXXXXXXXXXXXXXXXXXXXX";

        //设置header和payload，以下的字段都可以自定义
        $builder->setIssuer("XXX.com") //发布者
        ->setAudience("XXX.com") //接收者
        ->setId("abc", true) //对当前token设置的标识
        ->setIssuedAt(time()) //token创建时间
        ->setExpiration(time() + 300) //过期时间
        ->setNotBefore(time() + 5) //当前时间在这个时间前，token不能使用
        ->set('uid', 30061) //自定义数据
        ->set('name', '张三'); //自定义数据

        //设置签名
        $builder->sign($signer, $secret);
        //获取加密后的token，转为字符串
        $token = (string)$builder->getToken();
        dd($token);
    }

    public function verifyToken(Request $request)
    {
        function invalidToken($msg) {
            header('HTTP/1.1 403 forbidden');
            exit($msg);
        }

        $signer  = new Sha256();

        $secret = "XXXXXXXXXXXXXXXXXXXXX";

        //获取token
        $token = $request->input('token', '');

        if (!$token) {
            invalidToken('Invalid token');
        }

        try {
            //解析token
            $parse = (new Parser())->parse($token);
            //验证token合法性
            if (!$parse->verify($signer, $secret)) {
                invalidToken('Invalid token');
            }

            //验证是否已经过期
            if ($parse->isExpired()) {
                invalidToken('Already expired');
            }

            //获取数据
            $data = $parse->getClaims();

            dump($data['name']->getValue());
            dd($data['uid']->getValue());

        } catch (\Exception $e) {
            //var_dump($e->getMessage());
            invalidToken('Invalid token');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // //
        // Schema::create('user_emoji', function (Blueprint $table) {
        //     $table->Integer('ub_id')->comment('用户id');
        //     $table->Integer('e_id')->comment('表情id');
        //     $table->timestamps();
        // });
        // Schema::create('emoji_package', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('emoji_img')->comment('表情图片');
        //     $table->Integer('ub_id')->comment('创建用户id');
        //     $table->timestamps();
        //     $table->Integer('collect_num')->default(1)->comment('用户收藏数量');
        // });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
