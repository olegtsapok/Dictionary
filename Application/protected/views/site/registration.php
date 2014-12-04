<?php
/* @var $this SiteController */
/* @var $form CActiveForm */
?>

<h1>Registration</h1>

<div class="form">

<?php echo $form->renderBegin();

    echo $form->getActiveFormWidget()->errorSummary(array($form['user']->model));
    echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';

    echo $form['user']['first_name'];
    echo $form['user']['last_name'];
    echo $form['user']['email'];
    echo $form['user']['new_password'];

    echo '<input name="User[role]" value="'.CpRole::roleUser.'" type="hidden">';
    
    echo $form->renderButtons();
    echo $form->renderEnd();
?>


</div><!-- form -->