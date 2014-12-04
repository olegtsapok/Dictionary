<?php
/* @var $this LearnedController */
/* @var $model Learned */

$this->breadcrumbs=array(
	'Learneds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Learned', 'url'=>array('index')),
);
?>

<h1>Create Learned</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>