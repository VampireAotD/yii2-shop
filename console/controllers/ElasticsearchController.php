<?php

namespace console\controllers;

use console\models\Good;
use Elasticsearch\ClientBuilder;
use yii\console\Controller;

class ElasticsearchController extends Controller
{
    /**
     * @var ClientBuilder
     */
    private $builder;

    const HOSTS = [
        'localhost:9200'
    ];

    public function init()
    {
        parent::init();
        $this->builder = ClientBuilder::create()->setHosts(self::HOSTS)->build();
    }

    public function actionIndex()
    {
        $mappings = [
            'properties' => [
                'name' => [
                    'type' => 'text',
                    'analyzer' => 'custom_analyzer'
                ],
                'description' => [
                    'type' => 'text',
                    'analyzer' => 'custom_analyzer'
                ],
                'price' => [
                    'type' => 'double'
                ],
                'date' => [
                    'type' => 'date'
                ],
                'image' => [
                    'type' => 'keyword'
                ]
            ]
        ];

        $params = [
            'index' => 'products',
            'body' => [
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'russian_stopwords' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_'
                            ],
                            'custom_russian_stopwords' => [
                                'type' => 'stop',
                                'stopwords' => ['купить', 'найти', 'приобрести'],
                                'ignore_case' => true
                            ],
                            'ru_stemming' => [
                                'type' => 'snowball',
                                'language' => 'Russian'
                            ]
                        ],
                        'analyzer' => [
                            'custom_analyzer' => [
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'trim',
                                    'russian_stopwords',
                                    'custom_russian_stopwords',
                                    'ru_stemming'
                                ]
                            ]
                        ]
                    ],
                ],
                'mappings' => $mappings
            ]
        ];

        $res = $this->builder->index($params);

        print_r($res);
    }

    public function actionAddData()
    {
        $goods = Good::find()->asArray()->all();
        foreach ($goods as $good) {
            $this->builder->index([
                'index' => 'products',
                'id' => 'product-' . $good['id'],
                'body' => [
                    'id' => $good['id'],
                    'name' => $good['name'],
                    'description' => $good['description'],
                    'price' => $good['price'],
                    'date' => $good['date'],
                    'image' => $good['image'],
                ]
            ]);
        }
    }

    public function actionDeleteIndex()
    {
        $res = $this->builder->indices()->delete(['index' => 'products']);
        print_r($res);
    }
}