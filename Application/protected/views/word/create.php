<?php
/* @var $this WordController */
/* @var $model Word */

$this->breadcrumbs=array(
	'Words'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Word', 'url'=>array('index')),
);
?>

<h1>Create Word</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>