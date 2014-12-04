<?php

require_once '_components.inc';

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'name'=>'ProjectName',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	//'sourceLanguage'=>'en_US',

	// preloading components
	'preload'=>array('log', 'language', 'role'),

	// autoloading model and component classes
	'import'=>array(
		'application.controllers.*',
		'application.models.*',
		'application.models.forms.*',
		'application.components.*',
		'application.components.widgets.*',
	),

	'modules'=>array(
                'api' => array(
                ),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	// using Yii::app()->componentName
	'components'=> $components,

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',

                'dateTimeFormat'=>'dd/MM/yyyy HH:mm',
                'dateFormatPicker'=>'dd/mm/yy',
                'timeFormatPicker'=>'hh:mm',
	),
);