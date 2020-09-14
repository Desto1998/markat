<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h4 class="customer-profile-group-heading" style="margin: 0">Neue AQ erstellen</h4>
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