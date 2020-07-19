<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%slider}}".
 *
 * @property int $id
 * @property string $image_name
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $link_text
 * @property string $link_text_ru
 * @property string $link_text_en
 * @property string $link
 * @property string $html
 * @property string $html_ru
 * @property string $html_en
 * @property int $sort
 * @property int $status
 *
 * @property UploadedFile uploadedImageFile
 * @property string $image
 */
class Slider extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%slider}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SortableBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return array_filter([
            [['image_name'], 'required'],
            [['image_name'], 'string', 'max' => 50],
            [['title_ru', 'title_en', 'link_text_ru', 'link_text_en', 'link'], 'string', 'max' => 100],
            [['html_ru', 'html_en'], 'string'],
            [['sort', 'status'], 'integer'],

            [['uploadedImageFile', 'datum'], 'safe'],
            [['uploadedImageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            $this->isNewRecord ? ['uploadedImageFile', 'required'] : null,
        ]);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_name' => 'Изображение',
            'title_ru' => 'Заголовок Ru',
            'title_en' => 'Заголовок En',
            'html_ru' => 'Текст Ru',
            'html_en' => 'Текст En',
            'link_text_ru' => 'Текст кнопки Ru',
            'link_text_en' => 'Текст кнопки En',
            'link' => 'Ссылка',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getTitle()
    {
        return $this->getAttr('title');
    }

    public function getHtml()
    {
        return $this->getAttr('title');
    }

    public function getLink_text()
    {
        return $this->getAttr('link_text');
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
                $this->image_name = $id . '_' . time() . '.' . $this->uploadedImageFile->extension;
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
            if ($this->uploadedImageFile->extension != 'gif') {
                Image::thumbnail($path, $this->imageWidth, $this->imageHeight)->save($path);
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
