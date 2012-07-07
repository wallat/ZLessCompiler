ZLessCompiler
=============

A auto less compiler for Yii framework in developement enviroment

### What's this

This is a extension to help imlpementing LESS when in developement cycle. It compiles all the less files into css files of published assets on the fly. You should not use this extension in the production mode since it complies every each time.

### Why this one

This extension is to fit my situation:

1. I cannot install npm on my server. I need to use php to deal every thing.
2. I already have a exsiting website with lots of css. I want to modify as minimun as possible while importing less.
3. I do not need less in my production mode. I need to compile them into css files and just discard less components.

### How to use

1. Copy ZLessCompiler into your extension folder.
2. Setup the config file by adding two parts into config/main.php

        return array(
            // trigger compiler every time
            // Remove this part when is in production
            'behaviors' => array(
                'application.extensions.ZLessCompiler.ZLessBehavior',
            ),

            'components' => array(
                // The less compiler.
                // Remove this part when is in production
                'lessc' => array(
                    'class' => 'application.extensions.ZLessCompiler.ZLessCompiler',

                    // Because the constrain of lessphp, we need to specify the import path.
                    // And then you can do something like @import 'predefines.less';
                    // It will try to find this file in the following paths
                    'importDir' => array(
                        'application.assets.css'
                    )
                ),
            )
        );
3. Use less as the extension name for less files. Than they will be compiled when published. (Just stay un-touch with those CSS files. They just works fine.)

### Since I am a lazy guy

You do not need to modify any register code from *.css into *.less.

This code works fine when your file is common.less

        Yii::app()->getClientScript()->registerCssFile('/css/common.css');

### How about in the production mode

Since we still register *.css in the clientScript component, you can compile a css file in the same path with the less file. And them remove the "ZLessBehavior" and "lessc" setting in the config/main.php file. It just works fine ~

### Links

* [LESS](http://lesscss.org/)
* [leafo's lessphp](https://github.com/leafo/lessphp)

### Credits

* [好搜宅](http://www.howso.com.tw)
* [酷皮](http://www.coolpics.com.tw)
* [Yii's CSS&LESS components](http://www.yiiframework.com/extensions/?tag=css)
