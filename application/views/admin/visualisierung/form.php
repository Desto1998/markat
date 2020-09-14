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
        <?php echo render_input('plz', 'Postleitzahl', $value); ?>
    </div>
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->ort : ''); ?>
        <?php echo render_input('ort', 'Ort', $value); ?>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->strabe : ''); ?>
        <?php echo render_input('strabe', 'Stra�e', $value); ?>
    </div>

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->hausnummer : ''); ?>
        <?php echo render_input('hausnummer', 'Hausnummer', $value); ?>
    </div>
    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->wohnungsnumme : ''); ?>
        <?php echo render_input('wohnungsnumme', 'Wohnungsnummer', $value); ?>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <?php
        $data = [];
        $data[] = array('value' => 'UG');
        $data[] = array('value' => 'EG');
        $data[] = array('value' => '1. OG');
        $data[] = array('value' => '2. OG');
        $data[] = array('value' => '3. OG');
        $data[] = array('value' => '4. OG');
        $data[] = array('value' => '5. OG');
        $data[] = array('value' => '6. OG');
        $data[] = array('value' => '7. OG');
        $data[] = array('value' => '8. OG');
        $data[] = array('value' => '9. OG');
        $data[] = array('value' => '10. OG');
        $value = (isset($wohnungen) ? $wohnungen->etage : ''); ?>
        <?php echo render_select('etage', $data, array('value', 'value'), 'Etage', $value); ?>
    </div>
    <div class="col-md-4">
        <?php
        $data = [];
        $data[] = array('value' => 'Links');
        $data[] = array('value' => 'Rechts');
        $data[] = array('value' => 'Mitte');
        $data[] = array('value' => 'Mitte/Links');
        $data[] = array('value' => 'Mitte/Rechts');
        $value = (isset($wohnungen) ? $wohnungen->flugel : ''); ?>
        <?php echo render_select('flugel', $data, array('value', 'value'), 'Fl�gel', $value); ?>
    </div>

</div>
<div class="row">

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->zimmer : ''); ?>
        <?php echo render_input('zimmer', 'Zimmer', $value); ?>
    </div>

    <div class="col-md-4">
        <?php $value = (isset($wohnungen) ? $wohnungen->schlaplatze : ''); ?>
        <?php echo render_input('schlaplatze', 'Schlafpl�tze', $value); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php
        $selected = isset($wohnungen) ? $wohnungen->mobiliert : '';
        $datas = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
        echo render_select('mobiliert', $datas, array('id', 'value'), 'M�bliert', $selected, array()); ?>
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

<div class="row">
    <div class="col-md-12">
        <h4 style="margin-top: 65px">Inventarliste:
            <span class="bold" id="inventarCOunt"></span>
        </h4>
    </div>
</div>
<div class="row" id="tt-pop" style="margin-top: 25px; margin-bottom: 25px">
    <?php
    if (empty($wohnungen->inventer)):
        ?>
        <div class="col-md-6 count_cone field-clone simple">
            <div class="row" style="display: flex">
                <div class="col-md-1">
                    <div class="count-k">1</div>
                </div>
                <div class="col-md-2" style="padding-right: 5px !important;">
                    <input name="a_qty[]" style="margin-right: -10px;padding-right: 0 !important;"
                           class="form-control a_qty"
                           min="0" value="0"
                           type="number">
                </div>
                <div class="col-md-7">
                    <?php echo render_select('austattung[]', $inventarlistes, array('id', 'name'), '', $selected); ?>
                </div>

                <div class="col-md-2">
                    <a href="#"
                       class="btn remove-aq btn-danger disabled display-block  text-center">
                        <i class="fa fa-minus"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php else:
        $wohnungenOj = new Wohnungen_model();
        foreach ($wohnungen->inventer as $k => $a):
            ?>
            <div class="col-md-6 count_cone reasean <?php echo $a['is_deleted'] == 0 ? 'field-clone ' : ''; ?> "
                 data-id="<?= $a['id'] ?>" id="inventar-<?= $a['id'] ?>">
                <?php if ($a['is_deleted'] == 0):

                    $allData = get_move($wohnungen, $a['inventar_id']);
                    //  var_dump($allData);

                    ?>

                    <div class="row firstroun">
                        <div class="col-md-1">
                            <div class="count-k"><?= $k + 1 ?></div>
                        </div>
                        <div class="col-md-2">
                            <input name="a_qty[]" style="margin-right: -10px;padding-right: 0px !important;"
                                   class="form-control a_qty" min="0"
                                   type="number" value="<?= $a['qty'] ?>">
                        </div>
                        <div class="col-md-7 <?= $allData ? ' moved' : '' ?>">
                            <?php
                            echo render_select('austattung[]', $inventarlistes, array('id', 'name'), '', $a['inventar_id'], array(), array()); ?>
                        </div>
                        <div class="col-md-2">
                            <a href="#"
                               class="btn remove-aq btn-danger display-block  text-center">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    <?php
                    foreach ($allData as $item) {
                        ?>
                        <div class="row ">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2 text-center">
                                <?= $item['qty']; ?>
                            </div>
                            <div class="col-md-7">
                                <?= $this->wohnungen_model->get($item['to'])->strabe; ?>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <br>

                        <?php
                    }
                    ?>
                    <div class="row hide" id="deleted-reason">
                        <input type="hidden" name="delete[]" value="0"
                               class="deleted">

                        <div class="col-md-1">
                            <div class="count-k"><?= $k + 1 ?></div>
                        </div>
                        <div class="col-md-2">
                            <input style="margin-right: -10px;padding-right: 0px !important;"
                                   class="form-control" min="0" readonly
                                   type="number" value="<?= $a['qty'] ?>">
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" id="reasonsd-<?= $a['id'] ?>"
                                       readonly name="reasons[]"
                                       class="form-control reasonsd" value="<?= $a['reason'] ?>"></div>
                        </div>
                        <div class="col-md-2">
                            <a href="#"
                               class="btn remove-aqq btn-danger disabled display-block  text-center">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row" id="deleted-reason">
                        <input type="hidden" name="delete[]" value="1"
                               class="deleted">
                        <?php echo form_hidden('austattung[]', $a['inventar_id']) ?>
                        <div class="col-md-1">
                            <div class="count-k"><?= $k + 1 ?></div>
                        </div>
                        <div class="col-md-2">
                            <input style="margin-right: -10px;padding-right: 0px !important;" name="a_qty[]"
                                   class="form-control" min="1" readonly="<?= $a['is_deleted'] ? true : false ?>"
                                   type="number" value="<?= $a['qty'] ?>">
                        </div>

                        <div class="col-md-7">
                            <input type="hidden" name="reasons[]"
                                   class="reasonsd" value="<?= $a['reason'] ?>">

                            <div class="form-group">
                                <input type="text"
                                       readonly="true" id="reasonsd-<?= $a['id'] ?>"
                                       class="form-control reasonsd"
                                       value="<?= $wohnungenOj->get_inventar($a['inventar_id']) . ' (' . $a['reason'] . ')' ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="#"
                               class="btn remove-aqq btn-danger disabled display-block  text-center">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

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
<div class="text-right">
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</div>

<?php

function get_move($wohnungen, $inventar)
{
    $data = array();
    $movelds = $wohnungen->moved_items;
    foreach ($movelds as $moveld) {
        $allResources = unserialize($moveld['inventory']);
        foreach ($allResources as $item) {
            if ($item['inventory'] != $inventar)
                continue;
            array_push($data, $item);
        }
    }
    return $data;
}
