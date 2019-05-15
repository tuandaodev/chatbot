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
                        <h3 class="box-title">Client List</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-header">
                        <?php echo anchor('admin/clients/export_client', "Export Client", array('class' => 'btn btn-danger btn-flat')); ?>
                    </div>
                    <div class="box-body">
                        <table id="client-list-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>App ID</th>
                                    <th>FB UID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Phone Number</th>
                                    <th>Location</th>
                                    <th>Gift ID</th>
                                    <th>Gift Name</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($client_list as $client) { ?>
                                <tr>
                                    <td><?php echo $client['id'] ?></td>
                                    <td><?php echo $client['user_app_id'] ?></td>
                                    <td><?php 
                                    if ($client['user_fb_id'] ) {
                                        echo '<a target="_blank" href="https://www.facebook.com/profile.php?id=' . $client['user_fb_id'] . '">' . $client['user_fb_id'] . '</a>';
                                    } else {
                                        echo $client['user_fb_id'];
                                    }
                                    ?></td>
                                    <td><?php echo $client['first_name'] ?></td>
                                    <td><?php echo $client['last_name'] ?></td>
                                    <td><?php echo $client['gender'] ?></td>
                                    <td><?php echo $client['phone_number'] ?></td>
                                    <td><?php echo $client['location'] ?></td>
                                    <td><?php echo $client['gift_id'] ?></td>
                                    <td><?php echo $client['gift_name'] ?></td>
                                    <td><?php echo $client['created'] ?></td>
                                    <td><?php echo $client['updated'] ?></td>
                                </tr>
                            <?php } ?>

                            <!-- <tfoot>
                            </tfoot> -->
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>

