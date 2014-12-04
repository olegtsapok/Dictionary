<?php
/* @var $this DictionaryController */
/* @var $model Dictionary */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dictionary-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lang_source'); ?>
		<?php echo $form->dropDownList($model,'lang_source',
                        CHtml::listData(Language::model()->findAll(), 'id', 'name'),
                        array("empty" => "please select..") ); ?>
		<?php echo $form->error($model,'lang_source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lang_translation'); ?>
		<?php echo $form->dropDownList($model,'lang_translation',
                        CHtml::listData(Language::model()->findAll(), 'id', 'name'),
                        array("empty" => "please select..") ); ?>
		<?php echo $form->error($model,'lang_translation'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->