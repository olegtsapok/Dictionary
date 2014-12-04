<?php
/* @var $this WordController */
/* @var $model Word */

$this->breadcrumbs=array(
    'Words'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List Word', 'url'=>array('index')),
    array('label'=>'Create Word', 'url'=>array('create')),
    array('label'=>'Update Word', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Word', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Word #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'word',
		'translation',
		'dictionary_id',
	),
)); ?>
