<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QL\QueryList;


class QueryListController extends Controller
{
    /* http://www.querylist.cc/ */


    public function act(Request $request)
    {
//        $data = QueryList::get('http://cms.querylist.cc/bizhi/453.html')->find('img')->attrs('src');

        $html = file_get_contents(storage_path('html/maoyantop.html'));
//        $rules = [
//            // 标题
//            'select1' => ['.name a','html'],
//            // 采集
//            'select2' => ['.star','text'],
//            // 采集
////            'select3' => ['.board-img','src']
//        ];
//
//        $data = QueryList::html($html)->rules($rules)->range('.movie-item-info')->query()->queryData();


        $rules = ['select'=>['a>.board-img','src']];
        $data = QueryList::html($html)
//            ->attr('')
            ->range('.board-wrapper')
            ->rules($rules)
            ->queryData();

        dd($data);

    }
}
