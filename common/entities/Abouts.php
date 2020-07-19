<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%abouts}}".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $sub_title
 * @property string $sub_title_ru
 * @property string $sub_title_en
 * @property string $html
 * @property string $html_ru
 * @property string $html_en
 * @property string $image_name
 * @property int $sort
 * @property int $status
 *
 * @property UploadedFile uploadedImageFile
 * @property string $image
 */
class Abouts extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%abouts}}';
    }


    public function behaviors()
    {
        return [
            [
                'class' => SortableBehavior::class,
//                'scope' => function () {
//                }
            ],
        ];
    }

    public function rules()
    {
        return [
            [['html_ru', 'html_en'], 'string'],
            [['title_ru', 'title_en', 'sub_title_ru', 'sub_title_en'], 'string', 'max' => 100],
            [['image_name'], 'string', 'max' => 50],
            [['sort', 'status'], 'integer'],
            [['uploadedImageFile'], 'safe'],
            [['uploadedImageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
//            ['uploadedImageFile', 'required', 'when' => function () {
//                return !$this->image_name;
//            }, 'whenClient' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Заголовок Ru',
            'title_en' => 'Заголовок En',
            'sub_title_ru' => 'Под-заголовок Ru',
            'sub_title_en' => 'Под-заголовок En',
            'html_ru' => 'Текст Ru',
            'html_en' => 'Текст En',
            'image_name' => 'Изображение',
            'uploadedImageFile' => 'Изображение',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getTitle()
    {
        return $this->getAttr('title');
    }

    public function getSub_title()
    {
        return $this->getAttr('sub_title');
    }

    public function getHtml()
    {
        return $this->getAttr('html');
    }

    private function getAttr($attribute)
    {
        $attr = $attribute . '_' . Yii::$app->language;
        $def_attr = $attribute . '_' . Yii::$app->params['defaultLanguage'];
        return $this->$attr ?: $this->$def_attr;
    }

    #################### IMAGES ####################

    private $imageWidth = 1920;
    private $imageHeight = null;
    private $quality = 85;

    public function __construct(array $config = [])
    {
        $folderName = str_replace(['{', '}', '%'], '', $this::tableName());
        parent::__construct($config);
        $this->_folder = '/files/' . $folderName . '/';
        $this->_folderPath = Yii::getAlias('@files') . '/' . $folderName . '/';
    }

    public $uploadedImageFile;
    private $_folder;
    private $_folderPath;

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->uploadedImageFile = UploadedFile::getInstance($this, 'uploadedImageFile');
            if ($this->uploadedImageFile) {
                if (!$this->isNewRecord) {
                    $this->deleteImage();
                }
                if (!$this->image_name) {
                    /* @var $lastModel self */
                    $lastModel = self::find()->orderBy(['id' => SORT_DESC])->one();
                    $id = $lastModel->id + 1;
                } else {
                    $id = $this->id;
                }
                $this->image_name = $id . '_' . date('YmdHis') . '.' . $this->uploadedImageFile->extension;
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->uploadedImageFile) {
            $path = $this->_folderPath . $this->image_name;
            FileHelper::createDirectory(dirname($path, 1));
            $this->uploadedImageFile->saveAs($path);
            if ($this->uploadedImageFile->extension != 'svg') {
                Image::thumbnail($path, $this->imageWidth, $this->imageHeight)->save($path, ['quality' => $this->quality]);
            }
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->deleteImage();
    }

    public function deleteImage()
    {
        if ($this->image_name) {
            if (file_exists($this->_folderPath . $this->image_name)) {
                unlink($this->_folderPath . $this->image_name);
            }
        }
    }

    public function removeImage()
    {
        $this->deleteImage();
        $this->image_name = null;
        $this->save();
    }

    public function getImage()
    {
        return $this->_folder . $this->image_name;
    }
}
