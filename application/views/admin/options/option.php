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
                    <div class="box-header">
                        <h3 class="box-title">Options Page</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $message_public; ?>

                        <?php echo form_open(current_url(), array('class' => 'form', 'id' => 'form-admin-options')); ?>
                        <?php foreach ($options_text as $item): ?>

                        <div class="form-group">
                            <label for=""><?php echo $item['title']  ?></label>
                            <input type="text" class="form-control" name="<?php echo $item['name'] ?>"
                                id="<?php echo $item['name'] ?>" value="<?php echo $item['value'] ?>">
                        </div>

                        <?php endforeach; ?>
                        
                        <div class="form-group hidden" >
                            <label for=""><?php echo $gift_type['title'] ?></label>
                            
                            <select class="form-control" name="<?php echo $gift_type['name'] ?>" id="<?php echo $gift_type['name'] ?>" >
                                <option value="1" <?php if ($gift_type['value'] == 1) echo 'selected' ?>>Text</option>
                                <option value="2" <?php if ($gift_type['value'] == 2) echo 'selected' ?>>Image</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for=""><?php echo $obj_option_gift['title'] ?></label>
                            <select class="select2" name="<?php echo $obj_option_gift['name'] ?>[]" id="<?php echo $obj_option_gift['name'] ?>" multiple="multiple" style="width:100%;">
                                <?php foreach ($gift_list as $gift) { 
                                    if (in_array($gift['id'], $gift_list_selected)) {
                                    ?>
                                    <option value="<?php echo $gift['id'] ?>" selected><?php echo $gift['name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $gift['id'] ?>"><?php echo $gift['name'] ?></option>
                                <?php } }?>
                            </select>
                        </div>
                        
                        <div class="box-footer">
                            <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => "Save Options")); ?>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>