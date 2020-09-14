<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h4 class="customer-profile-group-heading" style="margin: 0">Neue lieferanten erstellen</h4>
            </div>
        </div>
        <div class="row" id="lieferanten">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open($this->uri->uri_string(), array('id' => 'lieferanten-form')); ?>
                        <?php $this->load->view('admin/lieferanten/form'); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .d-inline {
        display: inline-table;
    }

    .onoffswitch-label {
        margin-bottom: 0;
    }

    .swichable span {
        font-size: 18px;
    }
</style>
<?php init_tail(); ?>
<?php if (isset($lieferanten)) { ?>
    <!-- init table tasks -->
    <script>
        var lieferanten_id = '<?php echo $lieferanten->id; ?>';
    </script>
<?php } ?>
</body>
</html>
