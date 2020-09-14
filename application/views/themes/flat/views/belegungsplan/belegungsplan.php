<div class="panel_s section-heading section-files">
    <div class="panel-body">
        <h4 class="no-margin section-text">
            <pan><?php echo get_menu_option('belegungsplan', _l('Belegungsplan')) ?></pan>
            <?php if (has_permission('menu', '', 'edit')):
            ?>
            <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
            <?php endif; ?></a>
        </h4>
    </div>

    <div class="panel-body _buttons">
        <a href="#" class="btn btn-info mright5 pull-left display-block" data-toggle="modal"
           data-target="#newoccupation"><?php echo 'Erstellen'; ?></a>
    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <table class="table dt-table dt-table table-wohnungen" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th><?php echo _l('ID'); ?></th>
                <th><?php echo _l('Straße'); ?></th>
                <th><?php echo _l('Nr '); ?></th>
                <th><?php echo _l('Etage '); ?></th>
                <th><?php echo _l('Flügel  '); ?></th>
                <th><?php echo _l('Zimmer '); ?></th>
                <th><?php echo _l('Schlafplätze '); ?></th>
                <th><?php echo _l('Möbliert '); ?></th>
                <th><?php echo _l('Belegt von'); ?></th>
                <th><?php echo _l('Belegt bis'); ?></th>
                <th><?php echo _l('Mieter'); ?></th>
                <th><?php echo _l('Aktiv '); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($occupations as $occupation) { ?>
                <tr>
                    <td><?php echo $occupation['id']; ?></td>
                    <?php

                    //  $subjectOutput = '<a href="' . base_url('mieter/mieter/' . $occupation['id']) . '">' . $occupation['fullname'] . '</a>';
                    /* if ($occupation['trash'] == 1) {
                         $subjectOutput .= '<span class="label label-danger pull-right">' . _l('mieter_trash') . '</span>';
                     }*/


                    $subjectOutput = '<a href="' . admin_url('wohnungen/wohnungen/' . $occupation['wohnungen']) . '">' . $occupation['strabe'] . '</a>';

                    $subjectOutput .= '<div class="row-options-calendar"><a href="#" data-toggle="modal" data-target="#calendarmx' . $occupation['id'] . '">';
                    $subjectOutput .= '  <div class="selcet">Kalender</div></a>';


                    $subjectOutput .= '</div>';
                    $date = date_create($occupation['belegt_v']);
                    $belegt_v = date_format($date, 'd.m.Y');
                    $date = date_create($occupation['belegt_b']);
                    $belegt_b = date_format($date, 'd.m.Y');
                    $mieter = '<a href="' . base_url('mieter/mieter/' . $occupation['mieter']) . '">' . $occupation['fullname'] . '</a>';

                    ?>
                    <td><?php echo $subjectOutput; ?></td>
                    <td><?php echo $occupation['hausnummer']; ?></td>
                    <td><?php echo $occupation['etage']; ?></td>
                    <td><?php echo $occupation['flugel']; ?></td>
                    <td><?php echo $occupation['zimmer']; ?></td>
                    <td><?php echo $occupation['schlaplatze']; ?></td>
                    <td><?php echo $occupation['mobiliert'] == 1 ? 'Ja' : 'Nein'; ?></td>
                    <td><?php echo $occupation['belegt_v']; ?></td>
                    <td><?php echo $occupation['belegt_b']; ?></td>
                    <td><?php echo $mieter; ?></td>
                    <td><?php $toggleActive = '<div class="onoffswitch" data-toggle="tooltip">
    <input type="checkbox" data-switch-url="' . admin_url() . 'wohnungen/change_wohnungen_status" name="onoffswitch" class="onoffswitch-checkbox" id="' . $occupation['id'] . '" data-id="' . $occupation['id'] . '" ' . ($occupation['active'] == 1 ? 'checked' : '') . '>
    <label class="onoffswitch-label" for="' . $occupation['id'] . '"></label>
    </div>';
                        echo $toggleActive ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="newoccupation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span>Erstellen </span><?php echo get_menu_option('belegungsplan', _l('Belegungsplan')) ?></h4>
            </div>
            <div class="modal-body">

                <?php echo form_open(base_url('belegungsplan/assign'), array('id' => 'dsds')); ?>
                <input type="hidden" value="0" name="belegungsplan_id" id="belegungsplan_id">

                <div class="row field-cloneb">
                    <div class="col-md-6">
                        <?php
                        $value = ''; ?>
                        <?php echo render_date_input('belegt_v', 'Belegt von', $value, array(), array(), '', 'startdate'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php $value = ''; ?>
                        <?php echo render_date_input('belegt_b', 'Belegt bis', $value, array(), array(), '', 'enddate'); ?>
                    </div>
                </div>
                <br>

                <div class="row field-cloneb">
                    <div class="col-md-6">
                        <?php echo render_input('', 'Resttage', 0, 'number', array('readonly' => true), array(), '', 'resttage'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo render_input('', 'Ausstehend', 0, 'number', array('readonly' => true), array(), '', 'ausstehend'); ?>
                    </div>
                </div>
                <br>
                <div class="row field-cloneb">
                    <div class="col-md-6">
                        <?php echo render_input('break_days', 'Break days', 0, 'number', array(), array(), '', 'break_days'); ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $mieters = $this->mieter_model->get_mieters();
                        ?>
                        <?php echo render_select('mieter', $mieters, array('id', 'fullname'), 'Mieter', '', array('required' => true)); ?>

                    </div>
                    <div class="col-md-6">
                        <?php echo render_select('wohnungen', array(), array(), 'AQ', '', array('required' => true)); ?>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit"
                                    class="btn btn-info"><?php echo _l('submit'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        appValidateForm($('#dsds'), {belegt_v: 'required', belegt_b: 'required'});
    });
</script>

<?php
foreach ($occupations as $occupation):
    $hisOccupations = $this->wohnungen_model->get_occupations($occupation['wohnungen']);

    ?>
    <div class="modal fade" id="calendarmx<?= $occupation['id'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo _l('Kalender'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel_s">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <div class="dt-loader hide"></div>
                                    <div id="calendar_dd<?= $occupation['id'] ?>"></div>
                                </div>
                                <script>
                                    $(function () {
                                        var dd =  <?php echo json_encode($hisOccupations);?>;
                                        var data = [];
                                        var breackDay = [];
                                        for (let d of dd) {
                                            var stdate = moment(d.belegt_v, "DD.MM.YYYY").toDate();
                                            var b_mi = parseInt(d.break_days);
                                            var enddate = moment(d.belegt_b, "DD.MM.YYYY").toDate();

                                            var i = 0;
                                            var $progress_day = enddate;
                                            if (b_mi > 0) {
                                                while (i < b_mi) {
                                                    $progress_day = moment($progress_day).add(1, 'days').toDate();

                                                    if ($progress_day.getDay() == 0 || $progress_day.getDay() == 6) {
                                                    } else {
                                                        breackDay.push($progress_day.getTime());
                                                        i++;
                                                    }

                                                }

                                            }
                                            let ds = {name: d.fullname, startDate: stdate, endDate: enddate};
                                            data.push(ds);
                                        }
                                        console.log(data);

                                        $("#calendar_dd<?= $occupation['id'] ?>").calendar({
                                            enableContextMenu: true,
                                            language: 'de',
                                            enableRangeSelection: false,
                                            contextMenuItems: [/*
                                        {
                                            text: 'Update',
                                            click: editEvent
                                        },
                                        {
                                            text: 'Delete',
                                            click: deleteEvent
                                        }
                                    */],
                                            customDayRenderer: function (element, date) {
                                                if (breackDay.indexOf(date.getTime()) != -1) {
                                                    $(element).css('background-color', 'red');
                                                    $(element).css('color', 'white');
                                                    $(element).css('border-radius', '15px');
                                                }
                                            },
                                            mouseOnDay: function (e) {
                                                if (e.events.length > 0) {
                                                    var content = '';
                                                    content += '<div class="event-tooltip-content">'
                                                        + '<div class="event-name text-center"> <strong>Mieter</strong></div>'
                                                        + '<div class="event-name" style="color:' + e.events[0].color + '">  ' + e.events[0].name + '</div>'
                                                        + '</div>';

                                                    $(e.element).popover({
                                                        trigger: 'manual',
                                                        container: 'body',
                                                        html: true,
                                                        content: content
                                                    });

                                                    $(e.element).popover('show');
                                                }
                                            },
                                            mouseOutDay: function (e) {
                                                if (e.events.length > 0) {
                                                    $(e.element).popover('hide');
                                                }
                                            },
                                            dayContextMenu: function (e) {
                                                $(e.element).popover('hide');
                                            },
                                            dataSource: data
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
endforeach;
?>