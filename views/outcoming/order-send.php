<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Новое отправление';
$this->params['breadcrumbs'][] = $this->title;

pistol88\shop\assets\CreateOutcomingAsset::register($this);
\pistol88\shop\assets\BackendAsset::register($this);
?>

<div class="incoming-create">
    <div class="shop-menu">
        <?=$this->render('../parts/menu');?>
    </div>
    
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    
    <?php $form = ActiveForm::begin(); ?>
    <div id="incoming-list" style="width: 800px;">
    <?php $elementCount = 1; foreach ($orderElements as $element) { ?>
        <div class="row incoming-row">
            <div class="col-lg-8 col-xs-8">
                <input class="hidden-incoming-product-id" name="element[<?=$elementCount?>][productId]" type="hidden" value="<?=$element->model->id?>">
                <input class="hidden-incoming-product-id" name="element[<?=$elementCount?>][productName]" type="hidden" value="<?=$element->model->name?>">
                <input class="hidden-incoming-product-id" name="element[<?=$elementCount?>][amount]" type="hidden" value="<?=$element->count?>">
                <?=$elementCount?>. <strong><?=$element->count;?>шт. - <?=$element->model->name;?></strong> (Всего: <?=$element->model->amount?>) 
            </div>
            <div class="col-lg-2 col-xs-2"> 
                <a href="#" class="delete-incoming-row" style="font-weight: bold; color: red;">X</a> 
            </div>
        </div>
            <?php $stockCount = 1; foreach ($element->model->stocks as $stock) {?>
            <div class="row" style="margin-left:20px">
                <div class="col-lg-8 col-xs-8">
                    <input class="hidden-incoming-product-id" name="element[<?=$elementCount?>][stocks][<?=$stockCount?>][stockId]" type="hidden" value="<?=$stock->stock_id?>"><strong><?=$stock->name?></strong>(Всего: <?=$stock->amount?>)
                </div>
                <div class="col-lg-2 col-xs-2"> 
                    <input type="text" name="element[<?=$elementCount?>][stocks][<?=$stockCount?>][stockAmount]" value="0" style="width: 30px;"> 
                </div>
            </div>
           <?php $stockCount++; } ?>
    <?php $elementCount++;} ?>
    </div>
        
        <div class="form-group">
            <?= Html::submitButton('Добавить отправление', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>