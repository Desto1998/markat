<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <h4 class="customer-profile-group-heading" style="margin: 0">MEINE FIRMA</h4>
            </div>
        </div>
        <div class="row" id="firma">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'firma-form')); ?>
                        <?php $this->load->view('admin/firma/form'); ?>
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
<?php if (isset($firma)) { ?>
    <!-- init table tasks -->
    <script>
        var firma_id = '<?php echo $firma->id; ?>';
    </script>
<?php } ?>
</body>
</html>
