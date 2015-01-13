<?php
$this->breadcrumbs = array(
    $model->title,
);

$this->menu = array(
    array('label' => 'Home', 'icon' => 'home', 'url' => array('#'), 'active' => true),
    array('label' => 'Library', 'icon' => 'book', 'url' => array('#')),
    array('label' => 'Application', 'icon' => 'pencil', 'url' => array('#')),
    array('label' => 'Profile', 'icon' => 'user', 'url' => array('#')),
    array('label' => 'Settings', 'icon' => 'cog', 'url' => array('#')),
    array('label' => 'Help', 'icon' => 'flag', 'url' => array('#')),
);
?>
<h2><?php echo $model->title; ?></h2>
<p><?php echo $model->introtext; ?></p>
<p><?php echo $model->fulltext; ?></p>
