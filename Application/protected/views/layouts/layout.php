<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerScriptFile('/js/global.js'); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo" style="float:left; width:150px">
                    <?php echo CHtml::encode(Yii::app()->name); ?>
                </div>

		<div id="logo" style="float:left;width:10%">
                    
                </div>

                <?php if (Yii::app()->user->isSuperAdmin()): ?>
                    <div id="company" style="float:right; margin-top:10px">
                        <?php echo Yii::t('app', 'Company'); ?>
                        <?php /*echo CHtml::dropDownList(
                                      'select_company',
                                      Yii::app()->company->getCurrentCompany()->id,
                                      CHtml::listData(Company::model()->findAll(), 'id', 'name'),
                                      array('onchange' => 'changeSettings("company="+this.value)')
                                );/**/
                        ?>
                    </div>
                <?php endif; ?>


                <!--<div id="lang" style="float:right; margin-top:10px">
                    <?php echo Yii::t('app', 'Language'); ?>
                    <?php echo CHtml::dropDownList('select_language', Yii::app()->getLanguage(),
                                  Yii::app()->language->languages,
                                  array('onchange' => 'changeSettings("language="+this.value)')
                            );
                    ?>
                </div>-->
	</div><!-- header -->


        <?php
        //echo Yii::app()->user->data->role;
        //echo '<pre>'; print_r($_SESSION); echo '</pre>';

        ?>

	<div id="mainmenu" style="clear:both;">

		<?php
                    $menu = array();
                    if (!Yii::app()->user->isGuest) {
                        $menu = array(
                            //array('label'=>'Dashboard', 'url'=>array('/site/Dashboard')),
                            //array('label'=>'Company', 'url'=>array('/company/index')),
                            //array('label'=>'Campaign', 'url'=>array('/campaign/index')),
                            //array('label'=>'AroundMe', 'url'=>array('/aroundme/index')),
                            array('label'=>'User', 'url'=>array('/user/index')),
                            array('label'=>'Language', 'url'=>array('/language/index')),
                            //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                            //array('label'=>'Contact', 'url'=>array('/site/contact')),
                        );
                    }
                    $menu[] = array('label'=>'Registration', 'url'=>array('/site/registration'), 'visible'=>Yii::app()->user->isGuest);
                    $menu[] = array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest);
                    $menu[] = array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest);
                    
                    $this->widget('zii.widgets.CMenu',array(
			'items'=>$menu,
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
		All Rights Reserved.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
