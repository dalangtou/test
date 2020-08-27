<?php

namespace App\Http\Controllers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;

class ElasticsearchController extends Controller
{
    //https://www.elastic.co/guide/cn/elasticsearch/php/current/_quickstart.html

    //扩展插件 --https://blog.csdn.net/qq_32613479/article/details/80111590

    /*
     * var Client $client
     * */
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function action(Request $request)
    {
//
        $params = [
            'index' => 'shop',
            'type' => 'shop',
            'body' => [
//                'testField' => 'abc',
//                'name' => 'tom',
//                'age' => '19',
            ]
        ];

        $response = $this->client->index($params);

        dd($response);

        dd(json_decode($this->demo(), true));
    }

    public function set(Request $request)
    {
        $params = [
            'index' => 'shop',
            'body' => [
                'mappings' => [
                    'dynamic' => false,
                    'properties' => [
                        'id' => [
                            'type' => 'integer', //通常id是整型，可以设置类型为"integer"或"long"
                        ],
                        'name' => [
                            'type' => 'text', //text是字符串类型,会被分词处理，名字通常需要分词处理，指定中文分词器"ik_max_word"，搜索的时候指定"ik_smart"分词器,"keyword"类型不会被分词。
//                            'analyzer' => 'ik_max_word' //存入时选用 ik_max_word 中文分词处理 需要安装对应扩展
                            'search_analyzer' => 'ik_smart'
                        ],
                        'image' => [
                            'enabled' => false //不会参与检索
                        ],
                        'shop_name' => [
                            'type' => 'text',
//                            'analyzer' => 'ik_max_word' //存入时选用 ik_max_word 中文分词处理 需要安装对应扩展
                            'search_analyzer' => 'ik_smart',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword'
                                ]
                            ]
                        ],
                        'price' => [
                            'type' => 'double'
                        ]
                    ]
                ]
            ]
        ];
//        dd($params);

        $res = $this->client->indices()->putMapping($params);

        dd($res);
    }

    //简单数据建模 https://www.jianshu.com/p/098236cf3a44 (商城/博客)

    private function demo()
    {
        // 属性类型可以为以下几种
        $str = '{
            "properties": {
            "birthday": {
                "type": "date"
                },
                "score": {
                        "type": "float"
                },
                "sex": {
                        "type": "byte"
                },
                "is_teenger": {
                        "type": "boolean"
                },
                "id": {
                        "type": "long"
                },
                "relationship": {
                        "type": "object"
                },
                "money2": {
                        "type": "float"
                },
                "age": {
                        "type": "integer"
                },
                "money1": {
                        "type": "double"
                },
                "realname": {
                        "type": "text"
                },
                "username": {
                        "index": false,
                    "type": "keyword"
                }
            }
        }';

        return $str;
    }
}
