<div class="row">

    <div class="col-md-6">
        <?php $value = (isset($driver) ? $driver->name: ''); ?>
        <?php $attrs = (isset($driver) ? array() : array('autofocus' => true)); ?>
        <?php echo render_input('name', 'Driver name', $value, 'text', $attrs); ?>
        <div id="dryver_exists_info" class="hide"></div>
        <!-- <?php /*$value = (isset($driver) ? $driver->contact : ''); */ ?>
                        --><?php /*echo render_textarea('contact', 'driver_contact', $value); */ ?>


        <?php $value = (isset($driver) ? $driver->contact : ''); ?>
        <?php echo render_input('contact', 'Driver contact', $value); ?>

        <?php $value = (isset($driver) ? $driver->email : ''); ?>
        <?php echo render_input('email', 'Driver Email', $value, 'email', array('required' => true)); ?>

    </div>


        <?php /*if (get_option('company_requires_vat_number_field') == 1) {
            $value = (isset($lieferanten) ? $lieferanten->vat : '');
            echo render_input('vat', 'client_vat_number', $value);
        }*/ ?>






</div>

<div class="text-right">
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</div>