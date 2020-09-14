<div class="row">
    <div class="col-md-4">
        <?php
        $data = array();
        $select = (isset($wohnungen) ? $wohnungen->project : '');
        $data[] = array('id' => 'BOR');
        $data[] = array('id' => 'FER');
        $data[] = array('id' => 'TOPS');
        echo render_select('project', $data, array('id', 'id'), 'Projekt', $select); ?>

    </div>

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->plz : ''); ?>
        <?php echo render_input('plz', 'Plz', $value); ?>
    </div>
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->ort : ''); ?>
        <?php echo render_input('ort', 'Ort', $value); ?>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->strabe : ''); ?>
        <?php echo render_input('strabe', 'Straße', $value); ?>
    </div>

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->hausnummer : ''); ?>
        <?php echo render_input('hausnummer', 'Hausnummer', $value); ?>
    </div>
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->wohnungsnumme : ''); ?>
        <?php echo render_input('wohnungsnumme', 'Wohnungsnumme', $value); ?>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->etage : ''); ?>
        <?php echo render_input('etage', 'Etage', $value); ?>
    </div>
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->flugel : ''); ?>
        <?php echo render_input('flugel', 'Flügel', $value); ?>
    </div>

</div>
<div class="row">

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->zimmer : ''); ?>
        <?php echo render_input('zimmer', 'Zimmer', $value); ?>
    </div>

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->schlaplatze : ''); ?>
        <?php echo render_input('schlaplatze', 'Schlafplätze', $value); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php
        $selected = isset($wohnungen) ? $wohnungen->mobiliert : '';
        $datas = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
        echo render_select('mobiliert', $datas, array('id', 'value'), 'Möbliert', $selected, array()); ?>
    </div>

    <div class="col-md-4">
        <?php
        $selected = isset($wohnungen) ? $wohnungen->tierhaltung : '';
        $datas = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
        echo render_select('tierhaltung', $datas, array('id', 'value'), 'Tierhaltung', $selected, array()); ?>
    </div>

    <div class="col-md-4">
        <?php
        $selected = isset($wohnungen) ? $wohnungen->balkon : '';
        $datas = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
        echo render_select('balkon', $datas, array('id', 'value'), 'Balkon', $selected, array()); ?>
    </div>

</div>
<?php
$austattung = isset($wohnungen) && $wohnungen->austattung ? $wohnungen->austattung : '';
?>

<div class="row">
    <div class="col-md-12">
        <h4 style="margin-top: 65px">Inventarliste:
            <strong id="inventarCOunt"><?= empty($austattung) ? '' : count(unserialize($austattung)) ?></strong></h4>
    </div>
</div>
<div class="row" id="tt-pop" style="margin-top: 25px; margin-bottom: 25px">
    <?php

    if (empty($austattung) || !unserialize($austattung)):
        ?>
        <div class="col-md-6 field-clone">
            <div class="row" style="display: flex">
                <div class="col-md-1">
                    <div class="count-k">1</div>
                </div>
                <div class="col-md-2" style="padding-right: 5px !important;">
                    <input name="a_qty[]" style="margin-right: -10px;padding-right: 0 !important;" class="form-control"
                           min="0" value="0"
                           type="number">
                </div>
                <div class="col-md-7">
                    <?php echo render_select('austattung[]', $inventarlistes, array('id', 'name'), '', $selected); ?>
                </div>

                <div class="col-md-2">
                    <a href="#"
                       class="btn remove-aq btn-danger <?= $k == 0 ? 'disabled' : '' ?> display-block  text-center">
                        <i class="fa fa-minus"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php else:
        $austattung = unserialize($austattung);
        $a_qty = unserialize($wohnungen->a_qty);
        foreach ($austattung as $k => $a):
            ?>
            <div class="col-md-6 field-clone">
                <div class="row">
                    <div class="col-md-1">
                        <div class="count-k"><?= $k + 1 ?></div>
                    </div>
                    <div class="col-md-2">
                        <input name="a_qty[]" style="margin-right: -10px;padding-right: 0px !important;"
                               class="form-control" min="1"
                               type="number" value="<?= $a_qty[$k] ?>">
                    </div>
                    <div class="col-md-7">
                        <?php
                        echo render_select('austattung[]', $inventarlistes, array('id', 'name'), '', $a); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#"
                           class="btn remove-aq btn-danger <?= $k == 0 ? 'disabled' : '' ?> display-block  text-center">
                            <i class="fa fa-minus"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach;
    endif;
    ?>
    <div id="add-div" class="col-md-2">
        <a href="#" class="btn miet btn-info display-block  text-center">
            <i class="fa fa-plus"></i>
        </a>
    </div>
</div>
<!--
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
<style>
    .remove-aq {
        max-width: 38px !important;
    }
</style>