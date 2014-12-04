<?php
/* @var $this DictionaryController */
/* @var $model Dictionary */

$this->breadcrumbs=array(
    'Dictionaries'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'List Dictionary', 'url'=>array('index')),
    array('label'=>'Create Dictionary', 'url'=>array('create')),
    array('label'=>'Update Dictionary', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Dictionary', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Dictionary #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'name',
		'description',
		'lang_source',
		'lang_translation',
	),
)); ?>
