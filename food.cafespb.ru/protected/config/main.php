<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//print dirname(__FILE__).DIRECTORY_SEPARATOR; exit;
Yii::setPathOfAlias('intranet', dirname(__FILE__).'/../../../intranet.basespb.ru/protected/');
return array(
	'defaultController' => 'demands/index',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Доставка еды. Cafespb.ru ',
    'sourceLanguage' => 'en_US',
    'language' => 'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'intranet.models.*',
        'intranet.web.widgets.*',
        'intranet.models.dict.*',
        'intranet.models.relations.*',
        'intranet.models.food.*',
		'intranet.components.*',
        'intranet.components.actions.*',
        'intranet.extensions.util.*',
        'application.models.*',
		'application.components.*',
        'intranet.components.validators.*',
        'intranet.components.sms.*',
         'intranet.components.MyActiveRecordBehaviors.*',

	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
        'siteModul',

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'06261979',
			'ipFilters'=>array('*')
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'cache' => array(
                 'class' => 'system.caching.CFileCache',
         ),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                '<url:.*html>'=>'site/page',
			),
            'showScriptName'=>false,
		),
		
		'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=intra_cafespb',
            'emulatePrepare' => true,
            'username' => 'alexoster',
            'password' => 'snaveroanar4s',
            'charset' => 'utf8',
            'initSQLs' => array('set names utf8'),
            'schemaCachingDuration'=>0,
            'enableProfiling' => false,
            'enableParamLogging' => false,
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
                    'levels'=>'trace, info',
                    'categories'=>'system.*',
                ),
                array(
                    'class'=>'CEmailLogRoute',
                    'levels'=>'error, warning, profile',
                    'emails'=>'ivanpetrunya@yandex.ru',
                ),
              /*     array(
                  'class' => 'CProfileLogRoute',
                  'levels' => 'profile,trace',
                  'enabled' => true,
                   'showInFireBug' => true,
                 ),*/
         /*    array(
        'class' => 'CWebLogRoute',
        'levels' => 'error, warning, trace, profile',
    ),*/
            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'ivan.petrunja@gmail.com',
	),
);