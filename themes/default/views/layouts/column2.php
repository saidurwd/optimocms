<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
    <div class="span12">
        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            'brandLabel' => 'Optimo CMS',
            //'brandLabel' => CHtml::image(Yii::app()->theme->baseUrl . '/images/logo.png', 'Logo', array('style' => 'width:120px;')),
            'brandUrl' => array('/site/index'),
            'collapse' => true, // requires bootstrap-responsive.css
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.TbNav',
                    'items' => array(
                        array('label' => 'Home', 'url' => array('/site/index')),
                        array('label' => 'About Us', 'url' => array('/content/view', 'id' => 1)),
                        array('label' => 'Services', 'url' => array('/content/view', 'id' => 2)),
                        array('label' => 'Contact Us', 'url' => array('/site/contact')),
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                    ),
                ),
                array(
                    'class' => 'bootstrap.widgets.TbNav',
                    'htmlOptions' => array('class' => 'pull-right'),
                    'items' => array(
                        array('label' => Yii::app()->user->name, 'icon' => 'icon-user', 'url' => '#', 'items' => array(
                                array('label' => 'Login', 'icon' => 'icon-ok', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'icon' => 'icon-off', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                            )),
                    ),
                ),
            ),
        ));
        ?> 
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                'links' => $this->breadcrumbs,
            ));
            ?><!-- breadcrumbs -->
        <?php endif ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span3">
        <?php
        $this->widget('bootstrap.widgets.TbNav', array(
            'type' => TbHtml::NAV_TYPE_TABS, // '', 'tabs', 'pills' (or 'list')
            'stacked' => false, // whether this is a stacked menu
            'items' => $this->menu,
        ));
        ?>
    </div>
    <div class="span9">
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>
