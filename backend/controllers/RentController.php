<?php

namespace backend\controllers;

use common\entities\Products;
use Yii;
use common\entities\Rent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RentController implements the CRUD actions for Rent model.
 */
class RentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Rent::find(),
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Rent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (($model->status == 1) && (strtotime($model->date) > strtotime("now"))) {
                $model->product->in_rent = 1;
                $model->product->rent_to = $model->date;
            }else {
                $model->product->in_rent = 0;
                $model->product->rent_to = null;
            }
            $model->product->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Rent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная вами страница не существует.');
    }

    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        $model->status++;

        if (($model->status == 1) && (strtotime($model->date) > strtotime("now"))) {
            $model->product->in_rent = 1;
            $model->product->rent_to = $model->date;
        }else {
            $model->product->in_rent = 0;
            $model->product->rent_to = null;
        }
        $model->product->save();

        if ($model->status == 3) {
            $model->status = 0;
        }
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }
}
