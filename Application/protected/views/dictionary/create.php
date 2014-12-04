<?php
/* @var $this DictionaryController */
/* @var $model Dictionary */

$this->breadcrumbs=array(
	'Dictionaries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Dictionary', 'url'=>array('index')),
);
?>

<h1>Create Dictionary</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>