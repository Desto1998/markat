<div class="row">
    <div class="col-md-6">
        <h3>Private Informationen</h3>
        <!--  --><?php /*if (is_admin()): */ ?>
        <!--            <div class="row">
                <div class="col-md-12">
                    <?php /*$selected = isset($mieter) ? $mieter->betreuer : "";
                    echo render_select('betreuer', $betreuers, array('id', array('firstname', 'lastname')), 'Betreuer', $selected); */ ?>

                </div>
            </div>
        --><?php

        if (isset($mieter))
            echo form_hidden('id', $mieter->id);
        ?>

        <div class="row">

            <div class="col-md-12">
                <?php $fullname = (isset($mieter) ? $mieter->fullname : ''); ?>
                <?php echo render_input('fullname', 'Vollständiger Name', $fullname); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $vorname = (isset($mieter) ? $mieter->vorname : ''); ?>
                <?php echo render_input('vorname', 'Vorname', $vorname); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $nachname = (isset($mieter) ? $mieter->nachname : ''); ?>
                <?php echo render_input('nachname', 'Nachname', $nachname); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $email = (isset($mieter) ? $mieter->email : ''); ?>
                <?php echo render_input('email', 'Email', $email, 'email'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php $value = (isset($mieter) ? $mieter->strabe_m : ''); ?>
                <?php echo render_input('strabe_m', 'Straße', $value); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $value = (isset($mieter) ? $mieter->hausnummer_m : ''); ?>
                <?php echo render_input('hausnummer_m', 'Hausnummer', $value); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $value = (isset($mieter) ? $mieter->wohnungsnummer : ''); ?>
                <?php echo render_input('wohnungsnummer', 'Wohnungsnummer', $value); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $data = [];
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
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                $data = [];
                $data[] = array('value' => 'Links');
                $data[] = array('value' => 'Rechts');
                $data[] = array('value' => 'Mitte');
                $data[] = array('value' => 'Mitte/Links');
                $data[] = array('value' => 'Mitte/Rechts');
                $value = (isset($wohnungen) ? $wohnungen->flugel : ''); ?>
                <?php echo render_select('flugel', $data, array('value', 'value'), 'Flügel', $value); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $plz = (isset($mieter) ? $mieter->plz : ''); ?>
                <?php echo render_input('plz', 'PLZ', $plz); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $stadt = (isset($mieter) ? $mieter->stadt : ''); ?>
                <?php echo render_input('stadt', 'Stadt', $stadt); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $telefon_1 = (isset($mieter) ? $mieter->telefon_1 : ''); ?>
                <?php echo render_input('telefon_1', 'Telefon 1', $telefon_1); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $telefon_2 = (isset($mieter) ? $mieter->telefon_2 : ''); ?>
                <?php echo render_input('telefon_2', 'Telefon 2', $telefon_2); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $telefon_3 = (isset($mieter) ? $mieter->telefon_3 : ''); ?>
                <?php echo render_input('telefon_3', 'Telefon 3', $telefon_3); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $value = (isset($mieter) ? $mieter->notice : ''); ?>
                <?php echo render_textarea('notice', 'Notice', $value); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><?php echo 'Besonderheit' ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <?php $selected = isset($mieter) && $mieter->haustiere == '1' ? 1 : 0;
                        $datas = array(array('id' => 0, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                        echo render_select('haustiere', $datas, array('id', 'value'), 'Haustiere', $selected); ?>

                    </div>
                    <div class="col-md-6">

                        <?php $selected = isset($mieter) && $mieter->raucher == '1' ? 1 : 0;
                        $datas = array(array('id' => 0, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                        echo render_select('raucher', $datas, array('id', 'value'), 'Raucher', $selected); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- Added By Amogh Branch for moving upload positin -->
        <div class="row">
            <div class="col-md-12">
                <h3>Datien/Anh&auml;nge hochladen <?php if(isset($mieter)) { ?><span><a href="<?php echo site_url('admin/mieter/makePdf/'.$mieter->id); ?>" class="btn btn-default">Generate Pdf</a></span><?php } ?></h3>
                <div class="row">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-default add-post-attachments">
                            <i data-toggle="tooltip" title="<?php echo _l('newsfeed_upload_tooltip'); ?>"
                               class="fa fa-files-o"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="mieter-form-drop-zone">
                        <div class="dz-message" data-dz-message><span></span></div>
                        <div class="dropzone-previews mtop25"></div>
                    </div>
                </div>


                <div class="row">
                    <?php
                    foreach ($mieter->attachments as $k => $attachment) { ?>
                        <?php ob_start(); ?>
                        <div data-num="<?php echo $k; ?>"
                             data-mieter-attachment-id="<?php echo $attachment['id']; ?>"
                             class="task-attachment-col col-md-4">
                            <ul class="list-unstyled task-attachment-wrapper" data-placement="right"
                                data-toggle="tooltip" data-title="<?php echo $attachment['file_name']; ?>">
                                <li class="mbot10 task-attachment<?php if (strtotime($attachment['dateadded']) >= strtotime('-16 hours')) {
                                    echo ' highlight-bg';
                                } ?>">
                                    <div class="mbot10 pull-right task-attachment-user">
                                        <a href="#" class="pull-right"
                                           onclick="remove_mieter_attachment(this,<?php echo $attachment['id']; ?>); return false;">
                                            <i class="fa fa fa-times"></i>
                                        </a>
                                        <?php
                                        $externalPreview = false;
                                        $is_image = false;
                                        $path = get_upload_path_by_type('mieter') . $mieter->id . '/' . $attachment['file_name'];
                                        $href_url = site_url('download/file/mieterattachment/' . $attachment['attachment_key']);
                                        $isHtml5Video = is_html5_video($path);
                                        if (empty($attachment['external'])) {
                                            $is_image = is_image($path);
                                            $img_url = site_url('download/preview_image?path=' . protected_file_url_by_path($path, true) . '&type=' . $attachment['filetype']);
                                        } else if ((!empty($attachment['thumbnail_link']) || !empty($attachment['external']))
                                            && !empty($attachment['thumbnail_link'])) {
                                            $is_image = true;
                                            $img_url = optimize_dropbox_thumbnail($attachment['thumbnail_link']);
                                            $externalPreview = $img_url;
                                            $href_url = $attachment['external_link'];
                                        } else if (!empty($attachment['external']) && empty($attachment['thumbnail_link'])) {
                                            $href_url = $attachment['external_link'];
                                        }
                                        if (!empty($attachment['external']) && $attachment['external'] == 'dropbox' && $is_image) { ?>
                                            <a href="<?php echo $href_url; ?>" target="_blank" class=""
                                               data-toggle="tooltip"
                                               data-title="<?php echo _l('open_in_dropbox'); ?>"><i
                                                        class="fa fa-dropbox" aria-hidden="true"></i></a>
                                        <?php } else if (!empty($attachment['external']) && $attachment['external'] == 'gdrive') { ?>
                                            <a href="<?php echo $href_url; ?>" target="_blank" class=""
                                               data-toggle="tooltip"
                                               data-title="<?php echo _l('open_in_google'); ?>"><i
                                                        class="fa fa-google" aria-hidden="true"></i></a>
                                        <?php }
                                        echo $attachment['file_name'];
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="<?php if ($is_image) {
                                        echo 'preview-image';
                                    } else if (!$isHtml5Video) {
                                        echo 'mieter-attachment-no-preview';
                                    } ?>">
                                        <?php
                                        // Not link on video previews because on click on the video is opening new tab
                                        if (!$isHtml5Video){ ?>
                                        <a href="<?php echo(!$externalPreview ? $href_url : $externalPreview); ?>"
                                           target="_blank"<?php if ($is_image) { ?> data-lightbox="mieter-attachment"<?php } ?>
                                           class="<?php if ($isHtml5Video) {
                                               echo 'video-preview';
                                           } ?>">
                                            <?php } ?>
                                            <?php if ($is_image) { ?>
                                                <img src="<?php echo $img_url; ?>" class="img img-responsive">
                                            <?php } else if ($isHtml5Video) { ?>
                                                <video width="100%" height="100%"
                                                       src="<?php echo site_url('download/preview_video?path=' . protected_file_url_by_path($path) . '&type=' . $attachment['filetype']); ?>"
                                                       controls>
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php } else { ?>
                                                <i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i>
                                                <?php echo $attachment['file_name']; ?>
                                            <?php } ?>
                                            <?php if (!$isHtml5Video){ ?>
                                        </a>
                                    <?php } ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                            </ul>
                        </div>
                        <?php
                        $attachments_data[$attachment['id']] = ob_get_contents();
                        ob_end_clean();
                        echo $attachments_data[$attachment['id']];
                    } ?>
                </div>
            </div>
        </div>


    </div>

    <div class="col-md-6">


        <h3>Projekt</h3>
        <div class="row">
            <div class="col-md-6">
                <?php
                $selected = '';
                if (isset($mieter) && $mieter->projektname) {
                    $selected = $mieter->projektname;
                }
                echo render_project_select($projects, $selected, 'Projekt','projektname');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $baubeginn = (isset($mieter) ? _d($mieter->baubeginn) : ''); ?>
                <?php echo render_date_input('baubeginn', 'Baubeginn', $baubeginn); ?>
            </div>

            <div class="col-md-6">
                <?php $bauende = (isset($mieter) ? _d($mieter->bauende) : ''); ?>
                <?php echo render_date_input('bauende', 'Bauende', $bauende); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $beraumung = (isset($mieter) ? _d($mieter->beraumung) : ''); ?>
                <?php echo render_date_input('beraumung', 'Beräumung', $beraumung); ?>
            </div>
            <div class="col-md-6">
                <?php $ruckraumung = (isset($mieter) ? _d($mieter->ruckraumung) : ''); ?>
                <?php echo render_date_input('ruckraumung', 'Rückräumung', $ruckraumung); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Fenstereinbau</h4>

                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $datas = array(array('id' => "Vollsanierung", 'value' => 'Vollsanierung'), array('id' => 'Nur Fenster', 'value' => 'Nur Fenster'));
                        echo render_select('fenstereinbau', $datas, array('id', 'value'), 'Art', $selected); ?>

                    </div>
                    <div class="col-md-6">
                        <?php $fenstereinbau = (isset($mieter) ? _d($mieter->fenstereinbau) : ''); ?>
                        <?php echo render_date_input('fenstereinbau_d', 'Fenstereinbau Datum', $fenstereinbau); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Keller</h4>
                <div class="row">
                    <div class="col-md-4">
                        <?php $value = (isset($mieter) ? $mieter->k_nummer : ''); ?>
                        <?php echo render_input('k_nummer', 'Kellernummer', $value); ?>
                    </div>

                    <div class="col-md-4">
                        <?php $value = (isset($mieter) ? _d($mieter->k_baubeginn) : ''); ?>
                        <?php echo render_date_input('k_baubeginn', 'Keller Beräumung', $value); ?>
                    </div>

                    <div class="col-md-4">
                        <?php $value = (isset($mieter) ? _d($mieter->k_ruckraumung) : ''); ?>
                        <?php echo render_date_input('k_ruckraumung', 'Keller Rückräumung', $value); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Ausweichkeller</h4>

                <div class="row">
                    <div class="col-md-4">
                        <?php $value = (isset($mieter) ? $mieter->strabe_a : ''); ?>
                        <?php echo render_input('strabe_a', 'Straße', $value); ?>
                    </div>
                    <div class="col-md-4">
                        <?php $value = (isset($mieter) ? $mieter->hausnummer_a : ''); ?>
                        <?php echo render_input('hausnummer_a', 'Hausnummer', $value); ?>
                    </div>
                    <div class="col-md-4">
                        <?php $value = (isset($mieter) ? $mieter->kellernummer_a : ''); ?>
                        <?php echo render_input('kellernummer_a', 'Kellernummer', $value); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="margin-top: 15px">Belegungsplan</h4>
                                    </div>
                                </div>
                                <div class="row field-cloneb">
                                    <div class="col-md-6">
                                        <?php
        /*                                        $value = (isset($mieter) ? $mieter->belegt_v : ''); */ ?>
                                        <?php /*echo render_date_input('belegt_v', 'Belegt von', $value, array(), array(), array(), 'startdate'); */ ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php /*$value = (isset($mieter) ? $mieter->belegt_b : ''); */ ?>
                                        <?php /*echo render_date_input('belegt_b', 'Belegt bis', $value, array(), array(), array(), 'enddate'); */ ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php /*echo render_input('resttage', 'Resttage', '', '', array('readonly' => true), array(), array(), 'resttage'); */ ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php /*echo render_input('ausstehend', 'Ausstehend', '', '', array('readonly' => true), array(), array(), 'ausstehend'); */ ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#" data-toggle="modal" data-target="#picker-aq"
                                           class="btn btn-info mright5 pull-left display-block"><?php /*echo 'Choose Umsetzwohnungen'; */ ?></a>
                                    </div>
                                </div>-->
        <br>
        <h4>Umsetzwohnung</h4>
        <div class="row">
            <div class="col-md-6">
                <?php
                $datas = [];
                $datas[] = array('id' => 1, 'value' => 'Privat');
                $datas[] = array('id' => 2, 'value' => 'Gewerblich');
                $datas[] = array('id' => 3, 'value' => 'Keine');


                $selected = isset($mieter) ? $mieter->art_w : ''; ?>
                <?php echo render_select('art_w', $datas, array('id', 'value'), 'Art', $selected); ?>


            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $value = (isset($mieter) ? $mieter->strabe_p : ''); ?>
                <?php echo render_input('strabe_p', 'Straße', $value); ?>

            </div>
            <div class="col-md-6">
                <?php $value = (isset($mieter) ? $mieter->nr_p : ''); ?>
                <?php echo render_input('nr_p', 'Nr', $value); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $value = (isset($mieter) ? $mieter->etage_p : ''); ?>
                <?php echo render_input('etage_p', 'Etage', $value); ?>
            </div>

            <div class="col-md-6">
                <?php $value = (isset($mieter) ? $mieter->fulger_p : ''); ?>
                <?php echo render_input('fulger_p', 'Flügel', $value); ?>

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
                        <div class="col-md-5 <?= $allData ? ' moved' : '' ?>">
                            <?php echo render_select('austattung[]', $inventarlistes, array('id', 'name'), '', '', ['id' => 'austattungSelect'], [], '', 'austattungSelect'); ?>
                        </div>
                        <div class="col-md-2" style="padding: 0;">
                            <input name="sqr[]" readonly style="margin-right: -10px; padding-right: 0px !important;"
                                   class="form-control sqr" min="0" value=""
                                   type="number">
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
                    $inventar = $wohnungenOj->get_inventar($a['inventar_id'])
                    ?>
                    <div class="col-md-6 count_cone reasean <?php echo $a['is_deleted'] == 0 ? 'field-clone ' : ''; ?> "
                         data-id="<?= $a['id'] ?>" id="inventar-<?= $a['id'] ?>">
                        <?php if ($a['is_deleted'] == 0):
                            $allData = get_move($wohnungen, $a['inventar_id']);
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
                                <div class="col-md-5 <?= $allData ? ' moved' : '' ?>">
                                    <?= render_select('austattung[]', $inventarlistes, array('id', 'name'), '', $a['inventar_id'], ['id' => 'austattungSelect'], [], '', 'austattungSelect'); ?>
                                </div>
                                <div class="col-md-2" style="padding: 0;">
                                    <input name="sqr[]" readonly style="margin-right: -10px; padding-right: 0px !important;"
                                           class="form-control sqr" min="0" value="<?= $inventar->qubik * $a['qty'] ?>"
                                           type="number">
                                </div>
                                <div class="col-md-2">
                                    <a href="#"
                                       class="btn remove-aq btn-danger display-block  text-center">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </div>
                            </div>
                            <?php
                            if (isset($allData))
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
                                               value="<?= $inventar->name . ' (' . $a['reason'] . ')' ?>">
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
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <button type="submit" id="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
        </div>
    </div>
</div>
<?php
if (isset($mieter)): ?>
    <script>
        var mieter_id = '<?=$mieter->id; ?>';
    </script>
<?php else: ?>
    <script>
        var mieter_id = 0;
    </script>
<?php
endif;
?>
