<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h3 style="margin-top: 0">Mieter per Excel, CSV importieren</h3>
                        <hr class="hr-panel-heading"/>
                        <div class="row">
                            <div class="col-md-6 mtop15">
                                <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'import_form')); ?>
                                <?php echo form_hidden('clients_import', 'true'); ?>
                                <?php echo render_input('file_excel', '* Eine EXCEL Datei wählen', '', 'file'); ?>
                                <div class="form-group">
                                    <button type="button"
                                            class="btn btn-info import btn-import-submit"><?php echo _l('import'); ?></button>
                                    <a class="btn btn-success" href="<?= base_url().'assets/sample-data/mieter_demo_data.xlsx'?>">Download Sample Data EXCEL</a>
                                    <a class="btn btn-success" href="<?= base_url().'assets/sample-data/mieter_demo_data.csv'?>">Download Sample Data CSV</a>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script src="<?php echo base_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
<script>
    $(function () {
        appValidateForm($('#import_form'), {
            file_csv: {required: true, extension: "csv"},
            source: 'required',
            status: 'required'
        });
    });
</script>
</body>
</html>
