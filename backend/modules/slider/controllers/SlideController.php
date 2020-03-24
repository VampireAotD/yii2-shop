<?php

namespace backend\modules\slider\controllers;

use backend\models\Goods;
use backend\models\forms\ImageUpload;
use Yii;
use backend\models\Slide;
use backend\modules\slider\models\SlideSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SlideController implements the CRUD actions for Slide model.
 */
class SlideController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'add-image', 'create', 'delete'],
                        'roles' => ['admin', 'moderator']
                    ]
                ],
            ]
        ];
    }

    /**
     * Lists all Slide models.
     * @return mixed
     */
    public function actionIndex()
    {
        $slides = new Slide;
        $searchModel = new SlideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'slides' => $slides,
        ]);
    }

    /**
     * Displays a single Slide model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Slide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $slides = new Slide;
        if ($slides->countSlides() >= 8) {
            Yii::$app->session->setFlash('danger', 'Only 8 slides can be set!');
            return $this->redirect(['index']);
        }

        $model = new Slide();
        $goods = Goods::getGoodsList();
        $statuses = Slide::getStatusList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'goods' => $goods,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Updates an existing Slide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $goods = Goods::getGoodsList();
        $statuses = Slide::getStatusList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'goods' => $goods,
            'statuses' => $statuses,
        ]);
    }

    public function actionAddImage($id)
    {
        $slide = $this->findModel($id);
        $imageUpload = new ImageUpload;

        if (Yii::$app->request->isPost) {
            $imageUpload->image = UploadedFile::getInstance($imageUpload, 'image');
            if ($imageUpload->validate()) {
                $slide->image = Yii::$app->storage->saveFile($imageUpload->image, $slide->image, '@slides');
                if ($slide->save(false, ['image'])) {
                    return $this->redirect(['view', 'id' => $slide->id]);
                }
            }
        }

        return $this->render('image', compact('slide', 'imageUpload'));
    }

    /**
     * Deletes an existing Slide model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slide::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
