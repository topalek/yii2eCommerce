<?php

namespace common\models;

use Exception;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int         $id
 * @property string      $name        Name of the product
 * @property string|null $description Description
 * @property string|null $image       Image
 * @property float       $price       Price
 * @property int         $status      Status
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 * @property int|null    $updated_by
 *
 * @property CartItem[]  $cartItems
 * @property OrderItem[] $orderItems
 * @property User        $createdBy
 * @property User        $updatedBy
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'status'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['imageFile'], 'image', 'extensions' => 'jpg,png,jpeg,webp'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 2000],
            [
                ['created_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['created_by' => 'id'],
            ],
            [
                ['updated_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['updated_by' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Name',
            'description' => 'Description',
            'image'       => 'Product Image',
            'imageFile'   => 'Product Image',
            'price'       => 'Price',
            'status'      => 'Status',
            'statusName'  => 'Status',
            'statusBadge' => 'Status',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
            'created_by'  => 'Created By',
            'updated_by'  => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CartItemQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrderItemQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->imageFile) {
            $this->image = '/products/' . Yii::$app->security->generateRandomString(6) . '/' . $this->imageFile->name;
        }

        $transaction = Yii::$app->db->beginTransaction();
        $ok = parent::save($runValidation, $attributeNames);

        if ($ok && $this->imageFile) {
            if (!$this->saveImg()) {
                $transaction->rollBack();
                return false;
            }
        }
        $transaction->commit();
        return $ok;
    }

    public function saveImg()
    {
        $result = true;
        if ($this->image) {
            $fullPath = Yii::getAlias('@frontend/web/storage' . $this->image);
            $dir = dirname($fullPath);
            if (!FileHelper::createDirectory($dir) || !$this->imageFile->saveAs($fullPath)) {
                $result = false;
            }
        }
        return $result;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                TimestampBehavior::class,
                BlameableBehavior::class,
            ]
        );
    }

    /**
     * @return string
     */
    public function getImgUrl()
    {
        $url = Yii::$app->params['frontendUrl'];
        if (!$this->image) {
            $url .= '/img/no-photo.png';
        } else {
            $url .= '/storage' . $this->image;
        }
        return $url;
    }

    /**
     * @return string
     */
    public function getImgPreview()
    {
        return Html::img($this->getImgUrl(), ['style' => 'width:50px']);
    }

    /**
     * @return string[]
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_PUBLISHED => 'Active',
            self::STATUS_DRAFT     => 'Draft',
        ];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @return string
     */
    public function getStatusBadge()
    {
        return Html::tag(
            'span',
            $this->status ? 'Active' : 'Draft',
            ['class' => $this->status ? 'badge badge-success' : 'badge badge-danger']
        );
    }
}
