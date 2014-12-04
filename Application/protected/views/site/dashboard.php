<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

$company = new Company('search');
		$company->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$company->attributes=$_GET['Company'];

?>

<h1>Dashboard</h1>

<?php if (true): ?>

    <b>Users</b>
    <?php $this->renderPartial('/user/dashboard',array(
            'model'=>$model,
    )); ?>



    <b>Companies</b>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'company-grid',
            'dataProvider'=>$company->search(),
            'filter'=>$company,
            'columns'=>array(
                    'id',
                    'status',
                    'name',
                    'country',
                    'city',
                    'street',
                    array(
                            'class'=>'CButtonColumn',
                    ),
            ),
    )); ?>


<?php endif; ?>
