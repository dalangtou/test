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

    //中文分词器安装步骤 -- https://www.jianshu.com/p/fefe506bc902
    //中文分词器 -- https://github.com/medcl/elasticsearch-analysis-ik/releases
    /*
     * var Client $client
     * */
    private $client;

    //默认 9100 端口
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

    public function setIndex(Request $request)
    {
        /*$params = [
            'index' => 'shop',
            'body'  => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    'properties'=>[
                        'id'=>[
                            'type'=>'long'
                        ],
                        'name'=>[
                            'type'=>'text'
                        ],
                        'price'=>[
                            'type'=>'double'
                        ]
                    ]
                ]
            ]
        ];*/

        $params = [
            'index' => 'word',
            'body'  => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    'properties'=>[
                        'id'=>[
                            'type'=>'long'
                        ],
                        'title'=>[
                            'type'=>'ik_smart'
                        ],
                        'content'=>[
                            'type'=>'ik_smart'
                        ]
                    ]
                ]
            ]
        ];

        $res = $this->client->indices()->create($params);//设置索引

        dd($res);

        /*
         * IK分词器有两种分词模式：ik_max_word和ik_smart模式。

            1、ik_max_word

            会将文本做最细粒度的拆分，比如会将“中华人民共和国人民大会堂”拆分为“中华人民共和国、中华人民、中华、华人、人民共和国、人民、共和国、大会堂、大会、会堂等词语。

            2、ik_smart

            会做最粗粒度的拆分，比如会将“中华人民共和国人民大会堂”拆分为中华人民共和国、人民大会堂。

            测试两种分词模式的效果。分词查询要用GET、POST请求，需要把请求参数写在body中，且需要JSON格式。
        */
    }

    public function pushData(Request $request)
    {
        $params = [
            'index' => 'shop',
            'body'  => [
                'id' => '2',
                'name' => '杯子',
                'price'=>'9.68'
            ]
        ];

        $res = $this->client->index($params);//放入数据

        dd($res);
    }

    public function getAll(Request $request)
    {
        $index = $request->input('index');
        $id = $request->input('id');

        $params = [
            'index' => $index,//required
            'id' => $id//required
        ];

//        $res = $this->client->get($params);//获取指定索引/_id下的内容
        $res = $this->client->getSource($params);//获取指定索引/_id下的内容

        dd($res);
    }

    public function search(Request $request)
    {
        $index = $request->input('index');
        $name = $request->input('name');

        $params = [
            'index' => $index,
            'body'  => [
                'query' => [
                    'match' => [
                        'name' => $name
                    ]
                ]
            ]
        ];

        $res = $this->client->search($params);

        dd($res);
    }

    public function del(Request $request)
    {
        $index_name = $request->input('index_name');

        $params = [
            'index' => $index_name
        ];

        return $this->client->indices()->delete($params);
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
