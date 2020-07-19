<?php

namespace frontend\controllers;

use Yii;
use common\entities\Products;
use common\entities\ProductCategories;
use common\entities\Tariffs;
use frontend\components\FrontendController;
use yii\web\NotFoundHttpException;
use frontend\forms\FiltersForm;
use frontend\forms\RentForm;

class CatalogController extends FrontendController
{
    public function actionIndex($slug = null)
    {
        $this->findSeoAndSetMeta('catalog');
        $searchModel = new FiltersForm();
        if ($slug) {
            if (!$category = ProductCategories::findOne(['slug' => $slug])) {
                throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
            }
            $searchModel->category = $category->slug;
        }
        $queryParams = Yii::$app->request->queryParams;
//        var_dump(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGrid($slug = null)
    {
        $this->findSeoAndSetMeta('catalog');
        $searchModel = new FiltersForm();
        if ($slug) {
            if (!$category = ProductCategories::findOne(['slug' => $slug])) {
                throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
            }
            $searchModel->category = $category->slug;
        }
        $queryParams = Yii::$app->request->queryParams;
//        var_dump(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionIndex($slug = null)
//    {
//        if ($slug) {
//            if (!$category = ProductCategories::findOne(['slug' => $slug])) {
//                throw new NotFoundHttpException('Запрошенная вами страница не существует.');
//            }
//            $products = Products::find()->having(['category_status' => 1, 'status' => 1])->andWhere(['category_id' => $category->id])->all();
//        } else {
//            $category = ProductCategories::find()->having(['status' => 1])->orderBy(['sort' => SORT_ASC])->one();
//            $products = Products::find()->having(['category_status' => 1, 'status' => 1])->all();
//        }
//        $this->setMeta($category->title);
//        $model = new FiltersForm();
//
//        return $this->render('index', [
//            'products' => $products,
//            'category' => $category,
//            'model' => $model,
//        ]);
//    }

//    public function actionGrid($slug = null)
//    {
//        if ($slug) {
//            if (!$category = ProductCategories::findOne(['slug' => $slug])) {
//                throw new NotFoundHttpException('Запрошенная вами страница не существует.');
//            }
//            $products = Products::find()->having(['category_status' => 1, 'status' => 1])->andWhere(['category_id' => $category->id])->all();
//        } else {
//            $category = ProductCategories::find()->having(['status' => 1])->orderBy(['sort' => SORT_ASC])->one();
//            $products = Products::find()->having(['category_status' => 1, 'status' => 1])->all();
//        }
//        $this->setMeta($category->title);
//        $model = new FiltersForm();
//
//        return $this->render('grid', [
//            'products' => $products,
//            'category' => $category,
//            'model' => $model,
//        ]);
//    }

    public function actionMenuItem($slug)
    {
        /* @var $item Products */
        if (!$product = Products::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        return $this->render('product', [
            'product' => $product,
        ]);
    }

    public function actionItem($slug)
    {
        /* @var $item Products */
        if (!$product = Products::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        return $this->render('product', [
            'product' => $product,
        ]);
    }

    public function actionRent($slug)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Вначале необходимо') . ' <a class="mainUser" href="/site/login" style="text-decoration: underline">' . Yii::t('app', 'авторизоваться') . '</a>');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (!$product = Products::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        $tariffs = Tariffs::find()->having(['status' => 1, 'category' => 'one'])->orderBy('sort')->all();
        $form = new RentForm();
        if ($form->load(Yii::$app->request->post())) {
            $form->user_id = Yii::$app->user->id;
            $form->product_id = $product->id;
            if ($form->validate()) {
                if ($rent = $form->create()) {
                    try {
                        $form->mail($rent);
                    } catch (\RuntimeException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                    Yii::$app->session->setFlash('success', 'Спасибо за ваш заказ');
                    return $this->redirect(['/catalog/index']);
                }
            }
        } else {
            return $this->renderAjax('rent', [
                'model' => $form,
                'tariffs' => $tariffs,
            ]);
        }
    }
}