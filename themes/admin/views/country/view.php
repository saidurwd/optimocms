<?php
$this->pageTitle = 'Country details - ' . Yii::app()->name;
$this->breadcrumbs = array(
    'Countries' => array('admin'),
    $model->country_name,
);
?>
<div class="widget-box">
    <div class="widget-header">
        <h5>Details Country (<?php echo $model->country_name; ?>)</h5>
        <div class="widget-toolbar">
            <a data-action="settings" href="#"><i class="icon-cog"></i></a>
            <a data-action="reload" href="#"><i class="icon-refresh"></i></a>
            <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
            <a data-action="close" href="#"><i class="icon-remove"></i></a>
        </div>
        <div class="widget-toolbar">
            <?php echo CHtml::link('<i class="icon-pencil"></i>', array('update', 'id' => $model->id), array('data-rel' => 'tooltip', 'title' => 'Edit', 'data-placement' => 'bottom')); ?>
        </div>
        <div class="widget-toolbar">
            <?php echo CHtml::link('<i class="icon-plus"></i>', array('create'), array('data-rel' => 'tooltip', 'title' => 'Add', 'data-placement' => 'bottom')); ?>
        </div>
    </div><!--/.widget-header -->
    <div class="widget-body">
        <div class="widget-main">
            <?php
            $this->widget('bootstrap.widgets.TbDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'id',
                    'worldzone_id',
                    'country_name',
                    'country_3_code',
                    'country_2_code',
                    'ordering',
                    array(
                        'name' => 'published',
                        'value' => $model->published ? "Yes" : "No",
                    ),
                    array(
                        'name' => 'created_on',
                        'type' => 'raw',
                        'value' => date("F j, Y, g:i A", strtotime($model->created_on)),
                    ),
                    array(
                        'name' => 'created_by',
                        'type' => 'raw',
                        'value' => $model->getUserName($model->created_by),
                    ),
                    array(
                        'name' => 'modified_on',
                        'type' => 'raw',
                        'value' => date("F j, Y, g:i A", strtotime($model->modified_on)),
                    ),
                    array(
                        'name' => 'modified_by',
                        'type' => 'raw',
                        'value' => $model->getUserName($model->modified_by),
                    ),
                    array(
                        'name' => 'locked_on',
                        'type' => 'raw',
                        'value' => date("F j, Y, g:i A", strtotime($model->locked_on)),
                    ),
                    array(
                        'name' => 'locked_by',
                        'type' => 'raw',
                        'value' => $model->getUserName($model->locked_by),
                    ),
                ),
            ));
            ?>
        </div>
    </div><!--/.widget-body -->
</div><!--/.widget-box -->