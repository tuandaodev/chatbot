<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!-- <footer class="main-footer">
                <div class="pull-right hidden-xs">
                   
                </div>
                <strong><?php echo lang('footer_copyright'); ?> &copy; 2014-<?php echo date('Y'); ?>.</strong> <?php echo lang('footer_all_rights_reserved'); ?>.
            </footer> -->
</div>

<script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>

<?php if ($this->router->fetch_class() == 'clients'): ?>
        <script src="<?php echo base_url($plugins_dir . '/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>">
        <script>
                $(function () {
                        $('#client-list-table').DataTable()
                })
                </script>
<?php endif; ?>


<script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
<?php if ($mobile == TRUE): ?>
<script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
<script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
<script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
<script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
<script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
<script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
<script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script>

<?php if ($this->router->fetch_class() == 'options'): ?>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="<?php echo base_url($assets_dir . '/js/ad-options.js'); ?>"></script>
<?php endif; ?>

<?php if ($this->router->fetch_class() == 'stats'): ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="<?php echo base_url($assets_dir . '/js/stats.js'); ?>"></script>
    
<?php endif; ?>    
    
</body>

</html>