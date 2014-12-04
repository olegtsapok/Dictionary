<?php
/* @var $this LearnedController */
/* @var $model Learned */

$this->breadcrumbs=array(
    'Learneds'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List Learned', 'url'=>array('index')),
    array('label'=>'Create Learned', 'url'=>array('create')),
    array('label'=>'Update Learned', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Learned', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Learned #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
		'id',
		'user_id',
		'word_id',
	),
)); ?>
