<?php

$components = array(
        // custom components
        'language'=>array(
             'class'=>'CpLanguage',
         ),
        'dateTime'=>array(
             'class'=>'CpDateTime',
         ),

        // system components
        'user'=>array(
                'class'=>'CpWebUser',
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
                'loginUrl'=>array('site/login'),
                'returnUrl'=>array('dictionary/index'),
        ),

        'authManager'=>array(
            //'class' => 'CDbAuthManager',
            //'connectionID' => 'db',
            'class' => 'CPhpAuthManager',
        ),

        'role'=>array(
            'class' => 'CpRole',
        ),

        // uncomment the following to enable URLs in path-format
        /*
        'urlManager'=>array(
                'urlFormat'=>'path',
                'rules'=>array(
                        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
        ),
        */
        'db'=>array(
                'connectionString' => 'mysql:host=localhost;dbname=dictionary',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '_tsapok',
                'charset' => 'utf8',
        ),
        'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'site/error',
        ),
        'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                        array(
                                'class'=>'CFileLogRoute',
                                'levels'=>'error, warning',
                        ),
                        array(
                            'class'=>'CFileLogRoute',
                            'logPath'=>'logs',
                            'logFile'=>date('Y-m-d').'.log',
                            'categories'=>'api.*',
                            //'enabled' => YII_DEBUG,
                            'levels' => 'error, info',
                        ),
                        // uncomment the following to show log messages on web pages
                        /*
                        array(
                                'class'=>'CWebLogRoute',
                        ),
                        */
                ),
        ),

        // set default component paremeters
        'widgetFactory'=>array(
            'widgets'=>array(
                  'CLinkPager'=>array(
                      'maxButtonCount'=>'5',
                      'firstPageCssClass'=>'first-page',
                      'lastPageCssClass'=>'last-page',
                  ),
             ),
        ),
);
