<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Chacras de las Sierras',
        'defaultController' => 'Site/index',
	
        // user language (for Locale)
        'language'=>'es',
    
        //language for messages and views
        'sourceLanguage'=>'es',
 
        // charset to use
        'charset'=>'utf-8',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*'
	),

	'modules' => array(
			'gii'=>array(
	    		'class'=>'system.gii.GiiModule',
	    		'password'=>'chacras',
			),
	),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('site/index'),
		),
		
		// Image helper class
		'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                // GD or ImageMagick
                    'driver'=>'GD',
                // ImageMagick setup path
                    'params'=>array('directory'=>'C:/xampp/htdocs'),
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<action:\w+>/<id:\d+>/<name:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;port=3306;dbname=roberto_db',
			'emulatePrepare' => true,
			'username' => 'rob_user',//roberto_user
			'password' => 'K4GaBtLD22f4xFbc',//*pbWlteqmz^q
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                
                'request'=>array(
                    'enableCookieValidation'=>true,
                    //'enableCsrfValidation'=>true,
                ),
            
//                'session' => array(
//                        'class' => 'CCacheHttpSession',
//                ),
            
//		'cache' => array (
//                    'class' => 'system.caching.CMemCache',
//                    'servers'=>array(
//                            array(
//                                'host'=>'localhost',
//                                'port'=>11211,
//                            ),
//                    ),
//		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
            'useAmazonS3'=>false,
            'amazon'=>array(
                'key'=>'',
                'secret'=>'',
                'bucket'=>'',
                'sdkdir'=>'',
                'bucketDir'=>'',
            ),
            'smtp'=>array(
                'host'=> 'moonideas.com',
                'username'=> 'alerts@moonideas.com',
                'password'=> 'fJfhjdf7856S&df57sdf',
                'screenname'=> 'alerts'
            ),
            'mailchimp'=>array(
              'apiKey'=>'c2b0965fbbe705e23be83c2d87692cb8-us12',
              'endpoint'=>'https://us12.api.mailchimp.com/2.0/',
              'leadList'=>'28638a3049',
              'interestedList'=>'55c42238c5',
              'waitingSignatureList'=>'9faa06dc3e',
              'signedList'=>'0cac7133f3',
              'allList'=>'72402d0d5e',
            ),
            'mandrill'=>array(
                'subaccount'=>'roberto',
                'key'=>'xyzt4knOVKp4dnY0_d5R1A',
                'endPoint'=>'https://mandrillapp.com/api/1.0/',
            ),
            'facebook'=>array(
                'appId'=>'',
                'appSecret'=>'',
            ),
            'domain'=>'http://chacrasdelassierras.com',
            'cookies'=>array(
                'prefix'=> 'chacrasdelassierras'
             ),
            'google'=>array(
                'key'=>'AIzaSyDAFe2Um3ogdo4wxsK-x6zX6a5hN-DmaL0'
            ),
            'salt'=>'$2y$10$c7efb37223f19ec766a9cd2f08ff2d948a180e5b4944',
            'emails'=>array(
                'alerts'=> array(
                    'martinm@moonideas.com',
                    'matiascoppetti@gmail.com'
                ),
                'info'=> array(
                    'nacho@roberto.uy'
                )
             ),
             'security'=> array(
                 'fixedIpsInAdmin'=>false,
                 'adminIps'=>array(
                     
                 )
             )
        ),
        
);