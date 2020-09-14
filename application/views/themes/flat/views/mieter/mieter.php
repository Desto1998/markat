<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h4 class="customer-profile-group-heading" style="margin: 0">Mieter</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open($this->uri->uri_string(), array('id' => 'mieter-form')); ?>
                        <?php echo form_hidden('betreuer', get_contact_user_id()); ?>
                        <?php $this->load->view('admin/mieter/form'); ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
