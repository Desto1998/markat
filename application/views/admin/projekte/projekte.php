<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <h4 class="customer-profile-group-heading"
                    style="margin: 0">Neue <?= get_menu_option('projekte', _l('Projekte')) ?> erstellen</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel_s" id="projekte">
                    <div class="panel-body">
                        <?php
                        echo form_open($this->uri->uri_string(), array('class' => 'zone-dsd', 'id' => 'projekte-form')); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php $value = (isset($projekte) ? $projekte->datum : ''); ?>
                                        <?php echo render_date_input('datum', 'Datum', $value); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php $value = (isset($projekte) ? $projekte->wie : ''); ?>
                                        <?php echo render_input('wie', 'WIE', $value); ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php $value = (isset($projekte) ? $projekte->kunde : ''); ?>
                                        <?php echo render_select('kunde', $clients, array('userid', array('company')), 'Kunde', $value); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php $value = (isset($projekte) ? $projekte->auftrag : ''); ?>
                                        <?php echo render_input('auftrag', 'Auftrag', $value); ?>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $value = (isset($projekte) ? $projekte->mieter : ''); ?>
                                    <?php echo render_select('mieter', $mieters, array('id', array('fullname')), 'Mieter', $value); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php $value = (isset($projekte) ? $projekte->nummer : ''); ?>
                                    <?php echo render_input('nummer', 'Projektnummer', $value); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> <?php
                                    $selected = '';
                                    if (isset($wohnungen) && $wohnungen->project) {
                                        $selected = $wohnungen->project;
                                    }
                                    echo render_project_select($projects, $selected, 'Projekt');
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php $value = (isset($projekte) ? $projekte->projectname : ''); ?>
                                    <?php echo render_input('projectname', 'Projektname', $value); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php $value = (isset($projekte) ? $projekte->aq : ''); ?>
                                    <?php echo render_select('aq', $aqs, array('id', array('strabe', 'hausnummer', 'etage', 'flugel')), 'AQ', $value); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php $value = (isset($projekte) ? $projekte->user : ''); ?>
                                    <?php echo render_select('user', $staffs, array('staffid', array('firstname', 'lastname')), 'Mitabeiter', $value); ?>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <?php $value = (isset($projekte) ? $projekte->cars : ''); ?>
                                    <?php echo render_select('cars', $cars, array('id', array('marke', 'modell')), 'Fahzeuglist', $value); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <button type="submit" id="submit"
                                        class="btn btn-info"><?php echo _l('submit'); ?></button>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($projekte)): ?>
                        <script>
                            var projekte_id = '<?=$projekte->id; ?>';
                        </script>
                    <?php else: ?>
                        <script>
                            var projekte_id = 0;
                        </script>
                    <?php
                    endif;
                    ?>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php init_tail(); ?>
</body>
</html>
