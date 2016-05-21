<?php
namespace pistol88\shop\models;

use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "producer".
 *
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $text
 * @property string $slug
 */
class Producer extends \yii\db\ActiveRecord
{
	function behaviors() {
        return [
            'images' => [
                'class' => 'pistol88\gallery\behaviors\AttachImages',
                'inAttribute' => 'image',
            ],
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
            ],
            'seo' => [
                'class' => 'pistol88\seo\behaviors\SeoFields',
            ],
        ];
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_producer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['image', 'text'], 'string'],
            [['name', 'slug'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название производителя',
            'text' => 'Текст',
			'image' => 'Картинка',
			'slug' => 'SEO Имя',
        ];
    }
	
	 public function getLink() {
        return Url::toRoute(['/producer/view/', 'slug' => $this->slug]);
    }
	
	
	public function getByProducts($productFind)
	{
		$return = new Producer;
		$productFind = $productFind->select('producer_id');
		return $return::find()->where(['id' => $productFind]);
	}
}
