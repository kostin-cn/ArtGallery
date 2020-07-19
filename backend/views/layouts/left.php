<?php

use yii\helpers\Url;
use common\entities\ProductCategories;
use yii\helpers\ArrayHelper;

/* @var $user \common\entities\User */
/* @var $productCategory \common\entities\ProductCategories */
/* @var $productItems array */
/* @var $schoolItems array */

$user = Yii::$app->user->identity;

$productCategories = ProductCategories::find()->andWhere(['status' => 1])->orderBy('sort')->all();
foreach ($productCategories as $productCategory) {
    $ids = ArrayHelper::getColumn($productCategory->products, 'id');
    $productItems[] = ['label' => $productCategory->title_ru,
        'icon' => (
            ($this->context->id == 'products' && Yii::$app->controller->actionParams['slug'] == $productCategory->slug) or
            ($this->context->id == 'products' && in_array(Yii::$app->controller->actionParams['id'], $ids))
        ) ? 'folder-open' : 'folder',
        'active' => (
            Yii::$app->controller->actionParams['slug'] == $productCategory->slug or
            ($this->context->id == 'products' && in_array(Yii::$app->controller->actionParams['id'], $ids))
        ),
        'url' => ['/products', 'slug' => $productCategory->slug]];
}

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $user->userProfile->getAvatar('/files/anonymous.jpg') ?>"
                     class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $user->getPublicIdentity() ?></p>
                <a href="<?php echo Url::to(['/sign-in/profile']) ?>">
                    <i class="fa fa-circle text-success"></i>
                    <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                </a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Редактор', 'options' => ['class' => 'header']],
//                    ['label' => 'Файл-менеджер', 'icon' => 'file-image-o', 'url' => ['/file-manager']],
                    ['label' => 'Главная',
                        'icon' => (
                            Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'index'
                            or Yii::$app->controller->id == 'modules' && in_array(Yii::$app->controller->actionParams['id'], [2, 3])
                            or Yii::$app->controller->id == 'slider'
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            [
                                'label' => 'SEO',
                                'icon' => 'file-code-o',
                                'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'index'),
                                'url' => ['/seo/view', 'page' => 'index']
                            ],
                            ['label' => 'Слайдер', 'icon' => 'image', 'active' => (in_array(Yii::$app->controller->id, ['slider'])), 'url' => ['/slider']],
                            ['label' => 'Текст',
                                'icon' => 'file-text-o',
                                'active' => (Yii::$app->controller->id == 'modules' && Yii::$app->controller->actionParams['id'] == 2),
                                'url' => ['/modules/view', 'id' => 2],
                            ],
                            ['label' => 'Изображение под категориями',
                                'icon' => 'image',
                                'active' => (Yii::$app->controller->id == 'modules' && Yii::$app->controller->actionParams['id'] == 3),
                                'url' => ['/modules/view', 'id' => 3],
                            ],
                        ],
                    ],
                    ['label' => 'О Галерее',
                        'icon' => (
                            Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'about'
                            or Yii::$app->controller->id == 'modules' && in_array(Yii::$app->controller->actionParams['id'], [1])
                            or Yii::$app->controller->id == 'abouts'
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            [
                                'label' => 'SEO',
                                'icon' => 'file-code-o',
                                'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'about'),
                                'url' => ['/seo/view', 'page' => 'about']
                            ],
                            ['label' => 'Хедер',
                                'icon' => 'image',
                                'active' => (Yii::$app->controller->id == 'modules' && Yii::$app->controller->actionParams['id'] == 1),
                                'url' => ['/modules/view', 'id' => 1],
                            ],
                            ['label' => 'Блоки', 'icon' => 'newspaper-o', 'active' => ($this->context->id == 'abouts'), 'url' => ['/abouts']],
                        ],
                    ],
                    ['label' => 'Тарифы',
                        'icon' => (
                            Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'tariffs'
                            or Yii::$app->controller->id == 'tariffs'
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            [
                                'label' => 'SEO',
                                'icon' => 'file-code-o',
                                'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'tariffs'),
                                'url' => ['/seo/view', 'page' => 'tariffs']
                            ],
                            ['label' => 'Тарифы', 'icon' => 'file-text-o', 'active' => ($this->context->id == 'tariffs'), 'url' => ['/tariffs']],
                        ],
                    ],
                    ['label' => 'FAQ',
                        'icon' => (
                            Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'faq'
                            or Yii::$app->controller->id == 'faq'
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            ['label' => 'SEO', 'icon' => 'file-code-o', 'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'faq'), 'url' => ['/seo/view', 'page' => 'faq']],
                            ['label' => 'Статьи', 'icon' => 'newspaper-o', 'active' => ($this->context->id == 'faq'), 'url' => ['/faq']],
                        ]
                    ],
                    ['label' => 'Предложить работу',
                        'icon' => (
                            Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'offer'
                            or Yii::$app->controller->id == 'modules' && in_array(Yii::$app->controller->actionParams['id'], [4])
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            [
                                'label' => 'SEO',
                                'icon' => 'file-code-o',
                                'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'offer'),
                                'url' => ['/seo/view', 'page' => 'offer']
                            ],
                            ['label' => 'Хедер',
                                'icon' => 'image',
                                'active' => (Yii::$app->controller->id == 'modules' && Yii::$app->controller->actionParams['id'] == 4),
                                'url' => ['/modules/view', 'id' => 4],
                            ],
                        ],
                    ],
                    ['label' => 'Блог',
                        'icon' => (
                            Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'blog'
                            or Yii::$app->controller->id == 'articles'
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            ['label' => 'SEO', 'icon' => 'file-code-o', 'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'blog'), 'url' => ['/seo/view', 'page' => 'blog']],
                            ['label' => 'Статьи', 'icon' => 'newspaper-o', 'active' => ($this->context->id == 'articles'), 'url' => ['/articles']],
                        ]
                    ],
                    ['label' => 'Предложенные работы', 'icon' => 'image',
                        'active' => (
                            $this->context->id == 'offers'
                        ),
                        'url' => ['/offers']

                    ],
                    ['label' => 'Заказы', 'icon' => 'exclamation-triangle', 'active' => ($this->context->id == 'orders'), 'url' => ['/orders']],
                    ['label' => 'Аренда', 'icon' => 'file-text-o', 'active' => ($this->context->id == 'rent'), 'url' => ['/rent']],
                    ['label' => 'Магазин',
                        'icon' => (
                                Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'catalog'
                            or $this->context->id == 'product-categories'
                            or $this->context->id == 'products'
                            or $this->context->id == 'cities'
                            or $this->context->id == 'authors'
                            or $this->context->id == 'formats'
                            or $this->context->id == 'materials'
                            or $this->context->id == 'colors'
                            or $this->context->id == 'select-price'
                        ) ? 'folder-open' : 'folder', 'url' => '#',
                        'items' => [
                            ['label' => 'SEO', 'icon' => 'file-code-o', 'active' => (Yii::$app->controller->id == 'seo' && Yii::$app->controller->actionParams['page'] == 'catalog'), 'url' => ['/seo/view', 'page' => 'catalog']],
                            ['label' => 'Города', 'icon' => 'file-text-o', 'active' => ($this->context->id == 'cities'), 'url' => ['/cities']],
                            ['label' => 'Художники', 'icon' => 'user', 'active' => ($this->context->id == 'authors'), 'url' => ['/authors']],
                            ['label' => 'Форматы', 'icon' => 'file-text-o', 'active' => ($this->context->id == 'formats'), 'url' => ['/formats']],
                            ['label' => 'Материалы', 'icon' => 'file-text-o', 'active' => ($this->context->id == 'materials'), 'url' => ['/materials']],
                            ['label' => 'Цвета', 'icon' => 'file-text-o', 'active' => ($this->context->id == 'colors'), 'url' => ['/colors']],
                            ['label' => 'Выбор цен', 'icon' => 'file-code-o', 'active' => ($this->context->id == 'select-price'), 'url' => ['/select-price']],
                            ['label' => 'Жанры', 'icon' => 'bars', 'active' => ($this->context->id == 'product-categories'), 'url' => ['/product-categories']],
                            ['label' => 'Картины', 'icon' => ($this->context->id == 'products') ? 'folder-open' : 'folder', 'url' => '#',
                                'items' => $productItems
                            ],
                        ]
                    ],
                    ['label' => 'Стоимость доставки', 'icon' => 'money', 'active' => ($this->context->id == 'delivery-cost'), 'url' => ['/delivery-cost/view?id=1']],
                    ['label' => 'О Доставке', 'icon' => 'file-text-o', 'active' => (Yii::$app->controller->id == 'modules' && Yii::$app->controller->actionParams['id'] == 5), 'url' => ['/modules/view', 'id' => 5],],
                    ['label' => 'Контакты', 'icon' => 'address-book-o', 'active' => ($this->context->id == 'contacts'), 'url' => ['/contacts']],
                    ['label' => 'Соцсети', 'icon' => 'facebook', 'active' => ($this->context->id == 'socials'), 'url' => ['/socials']],
//                    ['label' => 'Модули', 'icon' => 'file-code-o', 'active' => ($this->context->id == 'modules'), 'url' => ['/modules']],
//                    ['label' => 'Seo', 'icon' => 'file-code-o', 'active' => ($this->context->id == 'seo'), 'url' => ['/seo']],
                    ['label' => 'Очистить кэш', 'icon' => 'exclamation-circle', 'url' => ['site/clear-cache']],
                ]
            ]
        ) ?>
    </section>
</aside>
