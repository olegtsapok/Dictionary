<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'Create User', 'url'=>array('create')),
);

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

<h1>Manage Users</h1>

<?php echo CHtml::beginForm(array('deleteItems')); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'user-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'selectableRows' => 2,
            'columns'=>array(
                    array(
                        'id' => 'selectedIds',
                        'class' => 'CCheckBoxColumn'
                    ),
                    array(
                        'name' => 'id',
                        'header' => 'ID',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->id, Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey)))',
                        'headerHtmlOptions' => array('width' => '60px'),
                    ),
                    'first_name',
                    'last_name',
                    'email',
                    array(
                            'header' => 'Role',
                            'value' => array($model, 'renderRole'),
                    ),
                    array(
                            'header' => 'Company',
                            'value' => array($model, 'renderCompany'),
                    ),
                    array(
                            'class'=>'CButtonColumn',
                            'template'=>'{update} {delete}',
                    ),
            ),
    )); ?>
    <div>
    <input type="button" value="Add" class="AddButton" onclick="location='<?=Yii::app()->controller->createUrl('create')?>'">
    <?php echo CHtml::submitButton('Del',
        array('name' => 'DeleteButton',
        'confirm' => 'Are you sure you want to permanently delete these items?'));
    ?>
    </div>
<?php echo CHtml::endForm(); ?>