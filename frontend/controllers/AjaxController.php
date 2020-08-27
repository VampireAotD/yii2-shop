<?php

namespace frontend\controllers;

use Elasticsearch\ClientBuilder;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller
{
    /**
     * @var ClientBuilder
     */
    private $builder;

    public function init()
    {
        parent::init();
        $this->builder = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionSearch(string $value)
    {
        $response = $this->builder->search([
            'index' => 'products',
            'body' => [
                'size' => 5,
                'query' => [
                    'multi_match' => [
                        'query' => $value,
                        'fields' => ['name^7', 'description^3', 'price^2'],
                        'fuzziness' => 'AUTO',
                        'tie_breaker' => 0.3,
                        'prefix_length' => 0
                    ]
                ]
            ]
        ]);

        if($response['hits']['hits']){
            return [
                'status' => true,
                'items' => $response['hits']['hits']
            ];
        }

        return [
            'status' => false,
        ];
    }
}