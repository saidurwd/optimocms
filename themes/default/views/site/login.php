<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>
<div style="width: 340px; margin: auto;">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'login-form',
        //'type' => 'horizontal',
        //'type' => 'inline',
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>
    <?php echo $form->textFieldRow($model, 'username', array('class' => 'span3', 'placeholder' => 'Username', 'prepend' => '<i class="icon-user"></i>')); ?>
    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span3', 'placeholder' => 'Password', 'prepend' => '<i class="icon-share"></i>')); ?>
    <?php echo $form->checkboxRow($model, 'rememberMe'); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'size' => '', 'icon' => 'icon-lock', 'label' => 'Login')); ?>
    <?php $this->endWidget(); ?>
</div>