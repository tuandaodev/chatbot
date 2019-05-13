<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Gift</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_group')); ?>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Gift Name</label>
                            <div class="col-sm-10">
                                <?php echo form_input($name); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="col-sm-2 control-label">Sub Title</label>
                            <div class="col-sm-10">
                                <?php echo form_input($subtitle); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image_url" class="col-sm-2 control-label">Image URL</label>
                            <div class="col-sm-10">
                                <?php echo form_input($image_url); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="group_name" class="col-sm-2 control-label">Gift Description</label>
                            <div class="col-sm-10">
                                <?php echo form_input($description); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php echo form_hidden('id', $id); //Gift_id ?>
                                <div class="btn-group">
                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                    <?php echo anchor('admin/gifts', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
