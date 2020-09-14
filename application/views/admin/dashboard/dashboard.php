<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<div id="wrapper">
    <div class="content">
        <div class="panel_s">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Herzlich Willkommen <?= get_staff_full_name() ?></h2>
                    </div>
                </div>
                <hr class="hr-panel-heading mbot40"/>
                <?php if (has_permission('dashboard', '', 'admin')) {
                    $this->load->view('admin/dashboard/dashboard_ceo');
                } else {
                    $this->load->view('admin/dashboard/dashboard_user');
                } ?>
            </div>
        </div>
    </div>
</div>

<?php init_tail();
?>
</body>
</html>
