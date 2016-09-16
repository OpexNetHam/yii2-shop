<?php
namespace pistol88\shop\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveQuery;

class StockToProduct extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%shop_stock_to_product}}';
    }
    
    public function rules()
    {
        return [
            [['product_id', 'stock_id', 'amount'], 'required'],
            [['product_id', 'stock_id', 'amount'], 'integer'],
        ];
    }
    
    public function getStock(){
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }

    public function getName(){
        if($stock = $this->stock) {
            return $this->stock->name;
        } else {
            return 'Склад без названия';
        }
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Адрес',
            'name' => 'Название',
            'text' => 'Текст',
        ];
    }
}
