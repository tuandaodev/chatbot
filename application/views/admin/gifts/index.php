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
									<h3 class="box-title"><?php echo anchor('admin/gifts/create', '<i class="fa fa-plus"></i> Create Gift', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
								</div>
								<div class="box-body">
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>ID</th>
												<th>Name</th>
                                                                                                <th>Sub Title</th>
                                                                                                <th>Image</th>
                                                                                                <th>Description</th>
												<th>Created</th>
                                                                                                <th>Options</th>
											</tr>
										</thead>
										<tbody>
<?php foreach ($gift_list as $gift) {?> 
											<tr>
												<td><?php echo $gift['id'] ?></td>
                                                                                                <td><?php echo $gift['name'] ?></td>
                                                                                                <td><?php echo $gift['subtitle'] ?></td>
                                                                                                <?php if ($gift['image_url']) { ?>
                                                                                                <td><img src="<?php echo $gift['image_url'] ?>" height="42" width="42"></td>
                                                                                                <?php } else { ?> 
                                                                                                <td>Not Set</td>
                                                                                                <?php } ?>
                                                                                                <td><?php echo $gift['description'] ?></td>
												<td><?php echo $gift['created'] ?></td>
												<td>
                                                                                                    <?php echo anchor('admin/gifts/edit/'.$gift['id'], "Edit"); ?>-
                                                                                                    <?php echo anchor('admin/gifts/delete/'.$gift['id'], "Delete"); ?>
												</td>
											</tr>
<?php }?>
										</tbody>
									</table>
								</div>
							</div>
						 </div>
					</div>
				</section>
			</div>
