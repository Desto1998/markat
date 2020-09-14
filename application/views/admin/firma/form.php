<div class="row">

    <div class="col-md-6">
        <?php $attrs = empty(get_option('f_company')) ? array('autofocus' => true) : array(); ?>
        <?php echo render_input('company', 'Firmenname', get_option('f_company'), 'text', $attrs); ?>
        <div id="company_exists_info" class="hide"></div>
        <?php echo render_input('vorname', 'Vorname', get_option('f_vorname')); ?>
        <?php echo render_input('nachname', 'Nachname', get_option('f_nachname')); ?>
        <?php echo render_input('strabe', 'Straße', get_option('f_strabe')); ?>
        <?php echo render_input('hausnummer', 'Hausnummer', get_option('f_hausnummer')); ?>
        <?php echo render_input('zip', 'Postleitzahl', get_option('f_zip')); ?>
        <?php echo render_input('city', 'Ort', get_option('f_city')); ?>
        <!--     <?php /*$value = (isset($firma) ? $firma->state : ''); */ ?>
        --><?php /*echo render_input('state', 'client_state', $value);
        $selected = (isset($firma) ? $firma->country : $customer_default_country);
        echo render_select('country', $countries, array('country_id', array('short_name')), 'clients_country', $selected, array('data-none-selected-text' => _l('dropdown_non_selected_tex')));
        */ ?>
    </div>
    <div class="col-md-6">

        <?php echo render_input('email', 'Email', get_option('f_email'), 'email'); ?>
        <?php echo render_input('phonenumber', 'Telefon', get_option('f_phonenumber')); ?>
        <?php echo render_input('phonenumber_1', 'Telefon 1', get_option('f_phonenumber_1')); ?>
        <?php echo render_input('mobil', 'Mobil', get_option('f_mobil')); ?>
        <?php if (empty(get_option('f_website'))) {
            echo render_input('website', 'client_website', get_option('f_website'));
        } else { ?>
            <div class="form-group">
                <label for="website"><?php echo _l('client_website'); ?></label>
                <div class="input-group">
                    <input type="text" name="website" id="website"
                           value="<?php echo get_option('f_website'); ?>" class="form-control">
                    <div class="input-group-addon">
                                        <span><a href="<?php echo maybe_add_http(get_option('f_website')); ?>"
                                                 target="_blank"
                                                 tabindex="-1"><i class="fa fa-globe"></i></a></span>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php echo render_input('firm_id', 'Umsatzsteuer-ID', get_option('f_firm_id')); ?>
        <?php $company_logo = get_option('company_logo'); ?>
        <?php $company_logo_dark = get_option('company_logo_dark'); ?>
        <?php if ($company_logo != '') { ?>
            <div class="row">
                <div class="col-md-9">
                    <img src="<?php echo base_url('uploads/company/' . $company_logo); ?>" class="img img-responsive">
                </div>
                <div class="col-md-3 text-right">
                    <a href="<?php echo admin_url('settings/remove_company_logo'); ?>" data-toggle="tooltip"
                       title="<?php echo _l('settings_general_company_remove_logo_tooltip'); ?>"
                       class="_delete text-danger"><i class="fa fa-remove"></i></a>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php } else { ?>
            <div class="form-group">
                <label for="company_logo"
                       class="control-label"><?php echo _l('settings_general_company_logo'); ?></label>
                <input type="file" name="company_logo" class="form-control" value="" data-toggle="tooltip"
                       title="<?php echo _l('settings_general_company_logo_tooltip'); ?>">
            </div>
        <?php } ?>
    </div>

</div>

<div class="text-right">
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</div>