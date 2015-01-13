<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <meta name="author" content="S.M. Saidur Rahman">
        <meta name="generator" content="Optimo CMS" />
        <?php Yii::app()->bootstrap->register(); ?>
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>     
        <?php //$this->widget('ext.widgets.googleAnalytics.EGoogleAnalyticsWidget', array('account' => 'WW-DDDDDDD-DD', 'domainName' => '.example.com')); ?>
    </head>
    <body>        
        <div id="wrap">
            <div class="container">
                <?php echo $content; ?> 
            </div>
            <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit">Copyright &copy; <?php echo date('Y'); ?> <?php echo Yii::app()->name; ?></p>
            </div>
        </div>        
    </body>
</html>
