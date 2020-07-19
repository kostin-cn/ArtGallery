<?php
namespace frontend\controllers;

use common\entities\Abouts;
use common\entities\Articles;
use common\entities\Contacts;
use common\entities\Faq;
use common\entities\Modules;
use common\entities\ProductCategories;
use common\entities\Products;
use common\entities\Slider;
use common\entities\Tariffs;

use frontend\forms\OfferForm;

use Yii;
use common\forms\LoginForm;
use frontend\components\FrontendController;
use yii\web\NotFoundHttpException;
use yii\web\Cookie;

class SiteController extends FrontendController
{
    public function actionIndex()
    {
        $this->findSeoAndSetMeta('index');
        $header = Modules::findOne(2);
        $img_cat = Modules::findOne(3);
        $slider = Slider::find()->having(['status' => 1])->orderBy('sort')->all();
        $best_products = Products::find()->having(['select' => 1])->andWhere(['status' => 1, 'approved' => 1, 'in_rent' => 0])->orderBy(['id'=>SORT_DESC])->limit(16)->all();
        $new_products = Products::find()->having(['status' => 1, 'approved' => 1, 'in_rent' => 0])->orderBy(['id'=>SORT_DESC])->limit(12)->all();
        $all_products = Products::find()->having(['status' => 1, 'approved' => 1, 'in_rent' => 0])->orderBy(['id'=>SORT_DESC])->all();
        $categories = ProductCategories::find()->having(['status' => 1])->orderBy('sort')->all();
        return $this->render('index', [
            'header' => $header,
            'img_cat' => $img_cat,
            'slider' => $slider,
            'categories' => $categories,
            'best_products' => $best_products,
            'new_products' => $new_products,
            'all_products' => $all_products,
        ]);
    }

    public function actionAbout()
    {
        $this->findSeoAndSetMeta('about');
        $header = Modules::findOne(1);
        $abouts = Abouts::find()->having(['status' => 1])->orderBy('sort')->all();
        return $this->render('about', [
            'header' => $header,
            'abouts' => $abouts,
        ]);
    }

    public function actionBlog()
    {
        $this->findSeoAndSetMeta('blog');
        $articles = Articles::find()->having(['status' => 1])->orderBy(['date' => SORT_DESC])->all();
        return $this->render('blog', [
            'articles' => $articles,
        ]);
    }

    public function actionArticle($slug)
    {
        if (!$article = Articles::find(['slug' => $slug])->having(['status' => 1])->one()) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        return $this->render('article', [
            'article' => $article,
        ]);
    }

    public function actionFaq()
    {
        $this->findSeoAndSetMeta('faq');
        $articles = Faq::find()->having(['status' => 1])->orderBy('sort')->all();
        return $this->render('faq', [
            'articles' => $articles,
        ]);
    }

    public function actionTariffs()
    {
        $this->findSeoAndSetMeta('tariffs');
        $ones = Tariffs::find()->where(['category' => 'one'])->having(['status' => 1])->orderBy('sort')->all();
        $series = Tariffs::find()->where(['category' => 'series'])->having(['status' => 1])->orderBy('sort')->all();
        return $this->render('tariffs', [
            'ones' => $ones,
            'series' => $series,
        ]);
    }

    public function actionOffer()
    {
        $this->findSeoAndSetMeta('offer');
        $header = Modules::findOne(4);
        $form = new OfferForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($product = $form->create()) {
                try {
                    $form->mail($product);
                } catch (\RuntimeException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Спасибо за доверие к нам'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->render('offer', [
            'header' => $header,
            'model' => $form,
        ]);
    }

    public function actionContacts()
    {
        $contacts = Contacts::getDb()->cache(function () {
            return Contacts::find()->having(['status' => 1])->orderBy('sort')->all();
        }, Yii::$app->params['cacheTime']);
        return $this->render('contacts', [
            'contacts' => $contacts,
        ]);
    }

    public function actionSetCookie() {
        if (Yii::$app->request->cookies->has('innart_dark')) {
            Yii::$app->response->cookies->remove('innart_dark');
        }else {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'innart_dark',
                'value' => 1,
            ]));
        }
    }

    #######################################################################

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $model->password = '';

            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }
}
