<?php

namespace frontend\forms;

use common\entities\Products;

use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use Yii;
use yii\base\Model;

/**
 * @property UploadedFile $uploadedImageFile
*/

class OfferForm extends Model
{
    public $author;
    public $phone;
    public $title;
    public $size;
    public $material;
    public $price;
    public $file;
    public $has_frame;
    public $in_stock;
    public $free_storage;
    public $link;

    public $data_collection_checkbox;

    public function rules()
    {
        return [
            [['price', 'has_frame', 'in_stock', 'free_storage'], 'integer'],
            [['author', 'title', 'uploadedImageFile'], 'required'],
            [['author', 'title', 'link', 'phone', 'material'], 'string', 'max' => 255],
            [['size', 'file'], 'string', 'max' => 50],

            [['data_collection_checkbox'], 'required', 'requiredValue' => 1, 'message' => Yii::t('app', 'Your Approve Required'),],

            [['uploadedImageFile'], 'safe'],
            [['uploadedImageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            ['uploadedImageFile', 'required', 'when' => function () {
                return !$this->file;
            }, 'whenClient' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'author' => Yii::t('app', 'Имя и фамилия'),
            'phone' => Yii::t('app', 'Ваш телефон'),
            'title' => Yii::t('app', 'Название работы'),
            'size' => Yii::t('app', 'Размеры работы в сантиметрах'),
            'material' => Yii::t('app', 'Материалы, из которых сделана работа'),
            'price' => Yii::t('app', 'Стоимость работы в рублях'),
            'file' => Yii::t('app', 'Загрузить работу'),
            'uploadedImageFile' => Yii::t('app', 'Загрузить работу'),
            'has_frame' => Yii::t('app', 'Наличие рамки (багета)'),
            'in_stock' => Yii::t('app', 'Будет ли в наличии в ближайший месяц?'),
            'free_storage' => Yii::t('app', 'Готов предоставить сервису работу на бесплатное хранение'),
            'link' => Yii::t('app', 'Ссылка на сайт или каталог работ (необязательно)'),
            'data_collection_checkbox' => Yii::t('app', 'Загружая работы и нажимая кнопку "Отправить" я принимаю условия договора-оферты с сервисом in-n-art'),
        ];
    }

    public function create()
    {
        $product = new Products();

        $product->status = 1;

        $product->author_ru = $this->author;
        $product->phone = $this->phone;
        $product->title_ru = $this->title;
        $product->size = $this->size;
        $product->material_ru = $this->material;
        $product->price = $this->price;
        $product->image_name = $this->file;
        $product->has_frame = $this->has_frame;
        $product->in_stock = $this->in_stock;
        $product->free_storage = $this->free_storage;
        $product->link = $this->link;

        if ($product->save()) {
            $path = $this->_folderPath . $this->file;
            FileHelper::createDirectory(dirname($path, 1));
            $this->uploadedImageFile->saveAs($path);
            if ($this->uploadedImageFile->extension != 'svg') {
                Image::thumbnail($path, $this->imageWidth, $this->imageHeight)->save($path, ['quality' => $this->quality]);
            }
        }
        return $product;
    }

    public function mail($product)
    {
        $this->sendToAdmin($product);
    }

    private $adminHtml;

    public function sendToAdmin($product)
    {
        /* @var $product Products */
        $variants = [
            0 => 'Нет',
            1 => 'Да',
        ];

        $this->adminHtml .= "<style>";
        $this->adminHtml .= ".h2{ font-size:2em; font-weight:lighter; text-transform:uppercase;}";
        $this->adminHtml .= "img{ width:200px;}";
        $this->adminHtml .= "</style>";
        $this->adminHtml .= "<table>";
        $this->adminHtml .= "<tr><td colspan='2' class='form-heading' ><h2>Клиент</h2></td><td></td></tr>";
        $this->adminHtml .= "<tr><td>Имя</td><td>: {$product->author_ru}</td></tr>";
        $this->adminHtml .= "<tr><td>Телефон</td><td>: {$product->phone}</td></tr>";
        $this->adminHtml .= "<tr><td>Название</td><td>: {$product->title_ru}</td></tr>";
        $this->adminHtml .= "<tr><td>Размер</td><td>: {$product->size}</td></tr>";
        $this->adminHtml .= "<tr><td>Материалы</td><td>: {$product->material_ru}</td></tr>";
        $this->adminHtml .= "<tr><td>Стоимость</td><td>: {$product->price}</td></tr>";
        $this->adminHtml .= "<tr><td>Изображение</td><td>: <img src='{$product->image}'> </td></tr>";
        $this->adminHtml .= "<tr><td>Наличие рамки</td><td>: {$variants[$product->has_frame]}</td></tr>";
        $this->adminHtml .= "<tr><td>Будет в наличии</td><td>: {$variants[$product->in_stock]}</td></tr>";
        $this->adminHtml .= "<tr><td>Согласие на хранение</td><td>: {$variants[$product->free_storage]}</td></tr>";
        $this->adminHtml .= "</table>";

        $sent = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Картина от ' . $this->author)
            ->setHtmlBody($this->adminHtml)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки E-mail.');
        }
    }

    #################### IMAGES ####################

    private $imageWidth = 1000;
    private $imageHeight = null;
    private $quality = 85;

    public function __construct(array $config = [])
    {
        $folderName = 'products';
        parent::__construct($config);
        $this->_folder = '/files/' . $folderName . '/';
        $this->_folderPath = Yii::getAlias('@files') . '/' . $folderName . '/';
    }

    public $uploadedImageFile;
    private $image_file_name = 'image_';
    private $_folder;
    private $_folderPath;

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->uploadedImageFile = UploadedFile::getInstance($this, 'uploadedImageFile');
            if ($this->uploadedImageFile) {
                $this->file = $this->image_file_name . date('YmdHis') . '.' . $this->uploadedImageFile->extension;
            }
            return true;
        }
        return false;
    }
}