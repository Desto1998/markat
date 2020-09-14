<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h4 class="customer-profile-group-heading" style="margin: 0">Neue AQ erstellen</h4>
            </div>
        </div>
        <div class="row" id="belegungsplan">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open($this->uri->uri_string(), array('id' => 'wohnungen-form')); ?>

                        <div class="row">
                            <div class="col-md-4">
                                <?php $strabe = (isset($wohnungen) ? $wohnungen->strabe : ''); ?>
                                <?php echo render_input('strabe', 'Straße', $strabe); ?>
                            </div>

                            <div class="col-md-4">
                                <?php $hausnummer = (isset($wohnungen) ? $wohnungen->hausnummer : ''); ?>
                                <?php echo render_input('hausnummer', 'Hausnummer', $hausnummer); ?>
                            </div>

                            <div class="col-md-4">
                                <?php $etage = (isset($wohnungen) ? $wohnungen->etage : ''); ?>
                                <?php echo render_input('etage', 'Etage', $etage); ?>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <?php $flugel = (isset($wohnungen) ? $wohnungen->flugel : ''); ?>
                                <?php echo render_input('flugel', 'Flügel', $flugel); ?>
                            </div>

                            <div class="col-md-4">
                                <?php $zimmer = (isset($wohnungen) ? $wohnungen->zimmer : ''); ?>
                                <?php echo render_input('zimmer', 'Zimmer', $zimmer); ?>
                            </div>

                            <div class="col-md-4">
                                <?php $schlaplatze = (isset($wohnungen) ? $wohnungen->schlaplatze : ''); ?>
                                <?php echo render_input('schlaplatze', 'Schlafplätze', $schlaplatze); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?php
                                $selected = isset($wohnungen) && $wohnungen->mobiliert == '1' ? 1 : 0;
                                $datas = array(array('id' => 0, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                                echo render_select('mobiliert', $datas, array('id', array('value')), 'Möbliert', $selected, array()); ?>
                            </div>

                            <div class="col-md-4">
                                <?php
                                $selected = isset($wohnungen) && $wohnungen->balkon == '1' ? 1 : 0;
                                $datas = array(array('id' => 0, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                                echo render_select('balkon', $datas, array('id', array('value')), 'Balkon', $selected, array()); ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="margin-top: 65px">Austattung</h4>
                            </div>
                        </div>

                        <div class="row" id="tt-pop" style="margin-top: 25px; margin-bottom: 25px">
                            <?php

                            $austattung = isset($wohnungen) && $wohnungen->austattung ? $wohnungen->austattung : '';
                            $datas = array();
                            $datas[] = array('option' => 'Bett 100x200');
                            $datas[] = array('option' => 'Bett 120x200');
                            $datas[] = array('option' => 'Bett 140x200');
                            $datas[] = array('option' => 'Bett 160x180');
                            $datas[] = array('option' => 'Esszimmertisch 100x80');
                            $datas[] = array('option' => 'Esszimmertisch 130x90');
                            $datas[] = array('option' => 'Couch 2 Sitzer');
                            $datas[] = array('option' => 'Couch 3 Sitzer');

                            if (empty($wohnungen->austattung)):
                                ?>
                                <div class="col-md-5 field-clone">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="count-k">1</div>
                                        </div>
                                        <div class="col-md-11">
                                            <?php
                                            echo render_select('austattung[]', $datas, array('option', 'option'), '', $selected); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else:
                                $austattung = unserialize($wohnungen->austattung);
                                foreach ($austattung as $a):
                                    ?>
                                    <div class="col-md-5 field-clone">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="count-k">1</div>
                                            </div>
                                            <div class="col-md-11">
                                                <?php
                                                echo render_select('austattung[]', $datas, array('option', 'option'), '', $a); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                            endif;
                            ?>

                            <div id="add-div" class="col-md-2">
                                <a href="#" class="btn miet btn-info display-block  text-center hidden-xs">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="margin-top: 65px">Belegungsplan</h4>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 25px; margin-bottom: 25px">
                            <div class="col-md-4">
                                <?php
                                $selected = isset($wohnungen) && $wohnungen->belegt == '1' ? 1 : 0;
                                $datas = array(array('id' => 0, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                                echo render_select('belegt', $datas, array('id', array('value')), 'Belegt', $selected); ?>
                            </div>
                        </div>
                        <?php
                        if (empty($wohnungen->belegt_v)):
                            ?>

                            <div class="row field-cloneb">
                                <div class="col-md-3">
                                    <?php echo render_date_input('belegt_v[]', 'Belegt von', '', array(), array(), array(), 'startdate'); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo render_date_input('belegt_b[]', 'Belegt bis', '', array(), array(), array(), 'enddate'); ?>
                                </div>

                                <div class="col-md-2">
                                    <?php echo render_input('resttage[]', 'Resttage', '', '', array('readonly' => true), array(), array(), 'resttage'); ?>
                                </div>
                                <div class="col-md-2">
                                    <?php echo render_input('ausstehend[]', 'Ausstehend', '', '', array('readonly' => true), array(), array(), 'ausstehend'); ?>
                                </div>

                                <div class="col-md-2">
                                    <?php echo render_select('mieter_p[]', $mieters, array('id', 'fullname'), 'Mieter', '', array(), array()); ?>
                                </div>
                            </div>
                        <?php else:
                            $belegt_v = unserialize($wohnungen->belegt_v);
                            $belegt_b = unserialize($wohnungen->belegt_b);
                            $ausstehend = unserialize($wohnungen->ausstehend);
                            $resttage = unserialize($wohnungen->resttage);
                            $mieter_p = unserialize($wohnungen->mieter_p);

                            foreach ($belegt_v as $k => $b):
                                ?>
                                <div class="row field-cloneb">
                                    <div class="col-md-3">
                                        <?php echo render_date_input('belegt_v[]', 'Belegt von', $belegt_v[$k], array(), array(), array(), 'startdate'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo render_date_input('belegt_b[]', 'Belegt bis', $belegt_b[$k], array(), array(), array(), 'enddate'); ?>
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo render_input('resttage[]', 'Resttage', $resttage[$k], '', array('readonly' => true), array(), array(), 'resttage'); ?>
                                    </div>

                                    <div class="col-md-2">
                                        <?php echo render_input('ausstehend[]', 'Ausstehend', $ausstehend[$k], '', array('readonly' => true), array(), array(), 'ausstehend'); ?>
                                    </div>

                                    <div class="col-md-2">
                                        <?php $selected = isset($mieter_p) ? $mieter_p[$k]->mieter_p : "";
                                        echo render_select('mieter_p[]', $mieters, array('id', 'fullname'), 'Mieter', $selected, array(), array()); ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        endif;
                        ?>
                        <div class="row">
                            <div id="add-divb" class="col-md-2 col-md-offset-5"><br>
                                <a href="#" class="btn miet btn-info display-block  text-center hidden-xs">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div><!--
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="margin-top: 65px">Mieter</h4>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 25px; margin-bottom: 25px">

                            <div class="col-md-4">
                                <?php
                        /*                                $selected = $wohnungen->mieter;
                                                        foreach ($mieters as $mieter) {
                                                            if (isset($wohnungen)) {
                                                                if ($mieter['id'] == $wohnungen->mieter) {
                                                                    $selected = $mieter['id'];
                                                                }
                                                            }
                                                        }
                                                        */ ?>
                                <?php /*echo render_select('mieter', $mieters, array('id', 'fullname'), 'Mieter', $selected); */ ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?php /*$value = (isset($wohnungen) ? $wohnungen->strabe_w : ''); */ ?>
                                <?php /*echo render_input('strabe_w', 'Straße', $value); */ ?>
                            </div>
                            <div class="col-md-4">
                                <?php /*$value = (isset($wohnungen) ? $wohnungen->hausnummer_w : ''); */ ?>
                                <?php /*echo render_input('hausnummer_w', 'Hausnummer', $value); */ ?>
                            </div>
                            <div class="col-md-4">
                                <?php /*$value = (isset($wohnungen) ? $wohnungen->postleitzahl : ''); */ ?>
                                <?php /*echo render_input('postleitzahl', 'Postleitzahl', $value); */ ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?php /*$value = (isset($wohnungen) ? $wohnungen->wohnort : ''); */ ?>
                                <?php /*echo render_input('wohnort', 'Wohnort', $value); */ ?>
                            </div>
                        </div>-->
                        <div class="text-right">
                            <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
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
<?php if (isset($wohnungen)) { ?>
    <!-- init table tasks -->
    <script>
        var wohnungen_id = '<?php echo $wohnungen->id; ?>';
    </script>
<?php } ?>
</body>
</html>
