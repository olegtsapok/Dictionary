<?php
/* @var $this LearnedController */
/* @var $model Learned */

$this->breadcrumbs=array(
    'Learneds'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

$this->menu=array(
    array('label'=>'List Learned', 'url'=>array('index')),
    array('label'=>'Create Learned', 'url'=>array('create')),
    array('label'=>'View Learned', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Learned <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>