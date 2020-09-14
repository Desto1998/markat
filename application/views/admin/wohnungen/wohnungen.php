<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <?php if (!isset($wohnungen)): ?>
                    <h4 class="customer-profile-group-heading" style="margin: 0">Neue AQ erstellen</h4>
                <?php else: ?>
                    <h4 class="customer-profile-group-heading" style="margin: 0"><?= $wohnungen->strabe ?></h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="row" id="wohnungen">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open($this->uri->uri_string(), array('id' => 'wohnungen-form')); ?>
                        <?php $this->load->view('admin/wohnungen/form'); ?>
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


<div class="modal fade" id="removeInventar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Warum m&ouml;chten Sie dieses Inventar l&#246;schen?
                </h4>
            </div>

            <div class="modal-body">
                <?php echo form_open('', array('id' => 'action-inventar')); ?>
                <input type="hidden" value="0" name="inventar" id="inventar_id">
                <div class="form-group">
                    <label for="credit_note_zip_status"><?php echo _l('Reason'); ?></label>
                    <div class="radio radio-primary">
                        <input type="radio" value="Defekt" id="Defekt" checked name="whyaction">
                        <label for="Defekt">Defekt </label>
                    </div>
                    <div class="radio radio-primary">
                        <input type="radio" value="Entsorgung" id="Entsorgung" class="raison" name="whyaction">
                        <label for="Entsorgung"><?php echo _l('Entsorgung'); ?></label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" id="gestreason"
                                    class="btn btn-info"><?php echo _l('submit'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<style>
    .remove-aq, .remove-aqq {
        max-width: 38px !important;
    }
</style>


<?php if (isset($wohnungen)) { ?>
    <!-- init table tasks -->
    <script>
        var wohnungen_id = '<?php echo $wohnungen->id; ?>';
    </script>
<?php } ?>
<script>
    appValidateForm($('#wohnungen-form'), {
        plz: 'required',
        ort: 'required',
        strabe: 'required',
        project: 'required',
        etage: 'required',
        flugel: 'required',
        schlaplatze: 'required',
        zimmer: 'required',
        hausnummer: 'required'
    });



</script>
</body>
</html>
