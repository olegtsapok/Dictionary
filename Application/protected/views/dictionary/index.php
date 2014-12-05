<?php
/* @var $this DictionaryController */
/* @var $model Dictionary */

$this->breadcrumbs=array(
    'Dictionaries'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'Create Dictionary', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#dictionary-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Dictionaries</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'dictionary-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
		'id',
		'name',
		'description',
		'lang_source',
		'lang_translation',
		'created_dt',
		/*
		'user_id',
		'type',
		*/
            array(
                    'class'=>'CButtonColumn',
            ),
    ),
)); ?>
