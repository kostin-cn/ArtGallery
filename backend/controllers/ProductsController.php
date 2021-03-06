<?php

namespace backend\controllers;

use Yii;
use backend\forms\ProductsSearch;
use common\entities\Products;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\entities\ProductCategories;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritdoc
     */
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

    public function actionIndex($slug)
    {
        $searchModel = new ProductsSearch();
        if (!$category = ProductCategories::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException('Запрошенная вами страница не существует.');
        }
        $searchModel->category_id = $category->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['id' => SORT_DESC]
        ];
//        $dataProvider = new ActiveDataProvider([
//            'query' => Products::find()->andWhere(['category_id' => $category->id, 'approved' => 1]),
//            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
//            'pagination' => false
//        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($slug)
    {
        if (!$category = ProductCategories::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException('Запрошенная вами страница не существует.');
        }
        $model = new Products();
        $model->category_id = $category->id;
        $model->approved = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'slug' => $slug]);
        }

        return $this->render('create', [
            'model' => $model,
            'category' => $category,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'slug' => $model->category->slug]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index', 'slug' => $model->category->slug]);
    }

    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная вами страница не существует.');
    }

    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        $model->status++;
        if ($model->status == 3) {
            $model->status = 0;
        }
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSelect($id)
    {
        $model = $this->findModel($id);
        $model->select = $model->select ? 0 : 1;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }
}
