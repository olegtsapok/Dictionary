<?php
/* @var $this UserController */
/* @var $model User */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php 
    if (!Yii::app()->user->isGuest)
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=> $model->search(),
	'filter'=>$model,
	'columns'=>array(
                array(
                    'header'          => 'Id',
                    'class'           => 'CLinkColumn',
                    'labelExpression' => '$data->primaryKey',
                    'urlExpression'   => 'Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))',
                ),
		'first_name',
		'last_name',
		'email',
		'phone',
		/*
		'role',
		*/
		array(
			'header' => 'Company',
			'value' => array($model, 'renderCompany'),
		),
		array(
                    'class'=>'CButtonColumn',
                    'viewButtonUrl' => 'Yii::app()->createUrl("user/view",array("id"=>$data->primaryKey))',
		),
	),
)); ?>
