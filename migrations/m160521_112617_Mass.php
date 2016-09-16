<?php

use yii\db\Schema;
use yii\db\Migration;

class m160521_112617_Mass extends Migration {

    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $connection = Yii::$app->db;
        try {
            $this->createTable('{{%shop_product}}', [
                'id' => Schema::TYPE_PK . "",
                'category_id' => Schema::TYPE_INTEGER . "(10)",
                'producer_id' => Schema::TYPE_INTEGER . "(11)",
                'related_products' => Schema::TYPE_TEXT . " COMMENT 'PHP serialize'",
                'name' => Schema::TYPE_STRING . "(200) NOT NULL",
                'code' => Schema::TYPE_STRING . "(155)",
                'text' => Schema::TYPE_TEXT . " NOT NULL",
                'short_text' => Schema::TYPE_STRING . "(255)",
                'images' => Schema::TYPE_TEXT . "",
                'available' => "enum('yes','no')" . " DEFAULT 'yes'",
                'sort' => Schema::TYPE_INTEGER . "(11)",
                'slug' => Schema::TYPE_STRING . "(255)",
                'related_ids' => Schema::TYPE_TEXT . "",
                ], $tableOptions);

            $this->createIndex('category_id', '{{%shop_product}}', 'category_id', 0);
            $this->createIndex('producer_id', '{{%shop_product}}', 'producer_id', 0);
            $this->createTable('{{%shop_category}}', [
                'id' => Schema::TYPE_PK . "",
                'parent_id' => Schema::TYPE_INTEGER . "(11)",
                'name' => Schema::TYPE_STRING . "(55) NOT NULL",
                'slug' => Schema::TYPE_STRING . "(255)",
                'text' => Schema::TYPE_TEXT . "",
                'image' => Schema::TYPE_TEXT . "",
                'sort' => Schema::TYPE_INTEGER . "(11)",
                ], $tableOptions);

            $this->createTable('{{%shop_price_type}}', [
                'id' => Schema::TYPE_PK . "",
                'name' => Schema::TYPE_STRING . "(55) NOT NULL",
                'sort' => Schema::TYPE_INTEGER . "(11)",
                'condition' => Schema::TYPE_TEXT . "",
                ], $tableOptions);
            
            $this->insert('{{%shop_price_type}}', [
                'id' => '1',
                'name' => 'Основная цена',
            ]);
            
            $this->createIndex('id', '{{%shop_category}}', 'id,parent_id', 0);
            $this->createTable('{{%shop_price}}', [
                'id' => Schema::TYPE_PK . "",
                'code' => Schema::TYPE_STRING . "(155) NOT NULL",
                'name' => Schema::TYPE_STRING . "(155) NOT NULL",
                'price' => Schema::TYPE_INTEGER . "(11)",
                'sort' => Schema::TYPE_INTEGER . "(11)",
                'amount' => Schema::TYPE_INTEGER . "(11)",
                'type_id' => Schema::TYPE_INTEGER . "(11)",
                'product_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'available' => "enum('yes','no')" . " DEFAULT 'yes'",
                ], $tableOptions);

            $this->createIndex('product_id', '{{%shop_price}}', 'product_id', 0);
            $this->createTable('{{%shop_producer}}', [
                'id' => Schema::TYPE_PK . "",
                'name' => Schema::TYPE_STRING . "(255) NOT NULL",
                'image' => Schema::TYPE_TEXT . "",
                'text' => Schema::TYPE_TEXT . "",
                'slug' => Schema::TYPE_STRING . "(255)",
                ], $tableOptions);

            $this->createTable('{{%shop_product_to_category}}', [
                'id' => Schema::TYPE_PK . "",
                'product_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'category_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                ], $tableOptions);

            $this->createTable( '{{%shop_incoming}}',[
                'id' => Schema::TYPE_PK . "",
                'date' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'content' => Schema::TYPE_TEXT . "",
            ], $tableOptions);

            $this->createTable( '{{%shop_outcoming}}',[
                'id' => Schema::TYPE_PK . "",
                'date' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'content' => Schema::TYPE_TEXT . "",
            ], $tableOptions);
            
            $this->createTable( '{{%shop_stock}}',[
                'id' => Schema::TYPE_PK . "",
                'name' => Schema::TYPE_STRING . "(255) NOT NULL",
                'address' => Schema::TYPE_STRING . "(255) NOT NULL",
                'text' => Schema::TYPE_TEXT . "",
            ], $tableOptions);

            $this->createTable('{{%shop_stock_to_product}}', [
                'id' => Schema::TYPE_PK . "",
                'product_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'stock_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'amount' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                ], $tableOptions);

            $this->createTable('{{%shop_stock_to_user}}', [
                'id' => Schema::TYPE_PK . "",
                'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                'stock_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
                ], $tableOptions);

            $this->addForeignKey(
                'fk_stock', '{{%shop_stock_to_product}}', 'stock_id', '{{%shop_stock}}', 'id', 'CASCADE', 'CASCADE'
            );

            $this->addForeignKey(
                'fk_category', '{{%shop_product}}', 'category_id', '{{%shop_category}}', 'id', 'CASCADE', 'CASCADE'
            );
            
            $this->addForeignKey(
                'fk_producer', '{{%shop_product}}', 'producer_id', '{{%shop_producer}}', 'id', 'CASCADE', 'CASCADE'
            );
            
            $this->addForeignKey(
                'fk_product', '{{%shop_price}}', 'product_id', '{{%shop_product}}', 'id', 'CASCADE', 'CASCADE'
            );
            
            $this->addForeignKey(
                'fk_type', '{{%shop_price}}', 'type_id', '{{%shop_price_type}}', 'id', 'CASCADE', 'CASCADE'
            );
            
            $this->addForeignKey(
                'fk_category', '{{%shop_product_to_category}}', 'category_id', '{{%shop_category}}', 'id', 'CASCADE', 'CASCADE'
            );
            
            $this->addForeignKey(
                'fk_product', '{{%shop_product_to_category}}', 'product_id', '{{%shop_product}}', 'id', 'CASCADE', 'CASCADE'
            );
            
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

    public function safeDown() {
        $connection = Yii::$app->db;
        try {
            $this->dropTable('{{%shop_product}}');
            $this->dropTable('{{%shop_category}}');
            $this->dropTable('{{%shop_price}}');
            $this->dropTable('{{%shop_producer}}');
            $this->dropTable('{{%shop_product_to_category}}');
            $this->dropTable('{{%shop_incoming}}');
            $this->dropTable('{{%shop_outcoming}}');
            $this->dropTable('{{%shop_stock}}');
            $this->dropTable('{{%shop_stock_to_product}}');
            $this->dropTable('{{%shop_stock_to_user}}');
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

}
