<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <?php echo $dashboard_alert_file_install; ?>
                    <div class="row">
                                               

                        <div class="clearfix visible-sm-block"></div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Clients</span>
                                    <span class="info-box-number"><?php echo $count_clients; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Users</span>
                                    <span class="info-box-number"><?php echo $count_users; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-shield"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Security groups</span>
                                    <span class="info-box-number"><?php echo $count_groups; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        </div>

                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Stats</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-center text-uppercase"><strong>Client Stats</strong></p>
                                            <div class="progress-group">
                                                <span class="progress-text">Today/Week</span>
                                                <span class="progress-number"><strong><?php echo $client_today ?></strong>/<?php echo $client_week ?></span>
                                                <div class="progress">
                                                    <?php if ($client_week>0 && round($client_today/$client_week*100)) { ?>
                                                    <div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="<?php echo round($client_today/$client_week*100); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($client_today/$client_week*100); ?>%"></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                <span class="progress-text">This Month/Total</span>
                                                <span class="progress-number"><strong><?php echo $client_month ?></strong>/<?php echo $client_total ?></span>
                                                <div class="progress">
                                                    <?php if ($client_total>0 && round($client_month/$client_total*100)) { ?>
                                                    <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="<?php echo round($client_month/$client_total*100); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($client_month/$client_total*100); ?>%"></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
