<?php
/* @var $this DictionaryController */
/* @var $model Dictionary */

$this->breadcrumbs=array(
    'Dictionaries'=>array('index'),
    $model->name=>array('view','id'=>$model->id),
    'Update',
);

$this->menu=array(
    array('label'=>'List Dictionary', 'url'=>array('index')),
    array('label'=>'Create Dictionary', 'url'=>array('create')),
    array('label'=>'View Dictionary', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Dictionary <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>