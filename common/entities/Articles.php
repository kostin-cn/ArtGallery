<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $short_descr
 * @property string $short_descr_ru
 * @property string $short_descr_en
 * @property string $description
 * @property string $description_ru
 * @property string $description_en
 * @property string $image_name
 * @property string $date
 * @property integer $status
 *
 * @property UploadedFile $uploadedImageFile
 * @property string $image
 */
class Articles extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%articles}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title_ru',
                'ensureUnique' => true
            ],
        ];
    }

    public function delete()
    {
        return parent::delete();
    }

    public function update($runValidation = true, $attributeNames = null)
    {
        return parent::update($runValidation, $attributeNames);
    }

    public function rules()
    {
        return [
            [['title_ru', 'short_descr_ru', 'description_ru', 'date'], 'required'],
            [['title_ru', 'title_en', 'image_name'], 'string', 'max' => 50],
            [['short_descr_ru', 'short_descr_en'], 'string', 'max' => 255],
            [['description_ru', 'description_en'], 'string'],
            [['status'], 'integer'],
            [['date'], 'date', 'format' => 'dd.MM.yyyy', 'timestampAttribute' => 'date', 'on' => ['create', 'update']],

            [['uploadedImageFile', 'attachments'], 'safe'],
            [['uploadedImageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
//            ['uploadedImageFile', 'required', 'when' => function ($model) {
//                return !$model->image_name;
//            }, 'whenClient' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'title_ru' => 'Заголовок Рус',
            'title_en' => 'Заголовок Eng',
            'short_descr_ru' => 'Краткое описание Рус',
            'short_descr_en' => 'Краткое описание Eng',
            'description_ru' => 'Текст Рус',
            'description_en' => 'Текст Eng',
            'image_name' => 'Изображение',
            'uploadedImageFile' => 'Изображение',
            'date' => 'Дата',
            'status' => 'Статус',
        ];
    }

    public function getTitle()
    {
        return $this->getAttr('title');
    }

    public function getShort_descr()
    {
        return $this->getAttr('short_descr');
    }

    public function getDescription()
    {
        return $this->getAttr('description');
    }

    private function getAttr($attribute)
    {
        $attr = $attribute . '_' . Yii::$app->language;
        $def_attr = $attribute . '_' . Yii::$app->params['defaultLanguage'];
        return $this->$attr ?: $this->$def_attr;
    }

    #################### IMAGES ####################

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->_folder = '/files/' . self::folderName . '/';
        $this->_folderPath = Yii::getAlias('@files') . '/' . self::folderName . '/';
    }

    const folderName = 'articles';
    const imageFileName = 'image_';

    public $uploadedImageFile;

    private $imageWidth = 1920;
    private $imageHeight = null;

    private $_folder;
    private $_folderPath;

    public function setImage()
    {
        FileHelper::createDirectory($this->_folderPath);
        $this->uploadedImageFile = UploadedFile::getInstance($this, 'uploadedImageFile');
        if ($this->uploadedImageFile) {
            if (!$this->isNewRecord) {
                $this->deleteImage();
            }
            $this->image_name = self::imageFileName . date('YmdHis') . '.' . $this->uploadedImageFile->extension;
        }
    }

    public function saveImage()
    {
        if ($this->uploadedImageFile) {
            $path = $this->_folderPath . $this->image_name;
            $this->uploadedImageFile->saveAs($path);
            Image::thumbnail($path, $this->imageWidth, $this->imageHeight)->save($path);
        }
    }

    public function deleteImage()
    {
        if ($this->image_name) {
            FileHelper::unlink($this->_folderPath . $this->image_name);
        }
    }

    public function getImage()
    {
        return $this->_folder . $this->image_name;
    }
}
