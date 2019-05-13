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
                        <h3 class="box-title"><?php echo anchor('admin/user_token/create', '<i class="fa fa-plus"></i> Create Token', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($token_list)) {
                                    foreach ($token_list as $token) { ?> 
                                        <tr>
                                            <td><?php echo $token['id'] ?></td>
                                            <td><?php
                                                if (strlen($token['value']) > 100) {
                                                    echo substr($token['value'], 0, 100) . "...";
                                                } else {
                                                    echo $token['value'];
                                                }
                                                ?></td>
                                            <td><?php echo $token['status'] ?></td>
                                            <td><?php echo $token['created'] ?></td>
                                            <td>
                                                <?php echo anchor('admin/user_token/edit/' . $token['id'], "Edit"); ?>-
        <?php echo anchor('admin/user_token/delete/' . $token['id'], "Delete"); ?>
                                            </td>
                                        </tr>
    <?php }
} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
