<?php

namespace common\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\behaviors\SluggableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $author_id
 * @property int $format_id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $authorName
 * @property string $author_ru
 * @property string $author_en
 * @property string $link
 * @property string $phone
 * @property string $slug
 * @property string $size
 * @property int $price
 * @property int $square
 * @property int $height
 * @property int $width
 * @property string $material
 * @property string $material_ru
 * @property string $material_en
 * @property string $description
 * @property string $description_ru
 * @property string $description_en
 * @property string $image_name
 * @property int $status
 * @property int $select
 * @property int $approved
 * @property int $has_frame
 * @property int $in_stock
 * @property int $free_storage
 * @property int $category_status
 * @property int $created_at
 * @property int $updated_at
 * @property int $in_rent
 * @property int $rent_to
 *
 * @property ProductColors[] $productColors
 * @property Colors[] $colors
 * @property ProductMaterials[] $productMaterials
 * @property Materials[] $materials
 * @property Authors $author
 * @property Formats $format
 *
 * @property ProductCategories $category
 * @property UploadedFile $uploadedImageFile
 * @property string $image
 */
class Products extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%products}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'productColors',
                    'colors',
                    'productMaterials',
                    'materials',
                ],
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title_ru',
                'slugAttribute' => 'slug',
                'ensureUnique' => true
            ],
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => null,
            ]
        ];
    }

    public function rules()
    {
        return [
            [['category_id', 'author_id', 'format_id', 'price', 'square', 'height', 'width', 'status', 'select', 'has_frame', 'in_stock', 'free_storage', 'category_status', 'created_at', 'updated_at', 'in_rent'], 'integer'],
            [['title_ru', 'price', 'image_name'], 'required'],
            [['description_ru', 'description_en'], 'string'],
            [['title_ru', 'title_en', 'author_ru', 'author_en', 'link', 'phone', 'slug', 'material_ru', 'material_en'], 'string', 'max' => 255],
            [['image_name', 'rent_to'], 'string', 'max' => 50],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['format_id'], 'exist', 'skipOnError' => true, 'targetClass' => Formats::class, 'targetAttribute' => ['format_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategories::class, 'targetAttribute' => ['category_id' => 'id']],

            [['uploadedImageFile', 'colors', 'materials',], 'safe'],
            [['uploadedImageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            ['uploadedImageFile', 'required', 'when' => function () {
                return !$this->image_name;
            }, 'whenClient' => true],
            ['category_id', 'required', 'on' => 'update'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Жанр',
            'author_id' => 'Автор',
            'format_id' => 'Формат',
            'materials' => 'Материалы',
            'colors' => 'Цвета',
            'title_ru' => 'Название работы',
            'title_en' => 'Название работы En',
            'author_ru' => 'Имя и фамилия',
            'author_en' => 'Имя и фамилия En',
            'link' => 'Ссылка на сайт или каталог работ (необязательно)',
            'phone' => 'Ваш телефон',
            'slug' => 'Slug',
            'price' => 'Стоимость работы в рублях',
            'size' => 'Размеры работы в сантиметрах',
            'height' => 'Высота в сантиметрах',
            'width' => 'Ширина в сантиметрах',
            'material_ru' => 'Материалы, из которых сделана работа',
            'material_en' => 'Материалы, из которых сделана работа En',
            'description_ru' => 'Описание Ru',
            'description_en' => 'Описание En',
            'image_name' => 'Изображение',
            'uploadedImageFile' => 'Изображение',
            'status' => 'Статус',
            'select' => 'Выбор кураторов',
            'approved' => 'В каталог',
            'has_frame' => 'Наличие рамки (багета)',
            'in_stock' => 'Будет ли в наличии в ближайший месяц?',
            'free_storage' => 'Готов предоставить сервису работу на бесплатное хранение',
            'in_rent' => 'В аренде',
            'rent_to' => 'Аренда до',
        ];
    }

    public function getProductColors()
    {
        return $this->hasMany(ProductColors::class, ['product_id' => 'id']);
    }

    public function getColors()
    {
        return $this->hasMany(Colors::class, ['id' => 'color_id'])->viaTable('{{%product_colors}}', ['product_id' => 'id']);
    }

    public function getProductMaterials()
    {
        return $this->hasMany(ProductMaterials::class, ['product_id' => 'id']);
    }

    public function getMaterials()
    {
        return $this->hasMany(Materials::class, ['id' => 'material_id'])->viaTable('{{%product_materials}}', ['product_id' => 'id']);
    }

    public function getAuthor()
    {
        $author = Authors::findOne($this->author_id);
        return $author->title;
    }

    public function getFormat()
    {
        return $this->hasOne(Formats::class, ['id' => 'format_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(ProductCategories::class, ['id' => 'category_id']);
    }

    public static function getAuthorsList()
    {
        return ArrayHelper::map(Authors::find()->orderBy('sort')->all(), 'id', 'title_ru');
    }

    public static function getCategoriesList()
    {
        return ArrayHelper::map(ProductCategories::find()->orderBy('sort')->all(), 'id', 'title_ru');
    }

    public static function getFormatsList()
    {
        return ArrayHelper::map(Formats::find()->orderBy('sort')->all(), 'id', 'title_ru');
    }

    public static function getMaterialsList()
    {
        return ArrayHelper::map(Materials::find()->orderBy('sort')->all(), 'id', 'title_ru');
    }

    public static function getColorsList()
    {
        return ArrayHelper::map(Colors::find()->orderBy('sort')->all(), 'id', 'title_ru');
    }


    public function getTitle()
    {
        return $this->getAttr('title');
    }

    public function getAuthorName()
    {
        return $this->getAttr('author');
    }

    public function getMaterial()
    {
        return $this->getAttr('material');
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

    private $imageWidth = 1000;
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
            $this->square = ($this->height * $this->width);
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
