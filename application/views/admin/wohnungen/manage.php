<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/gantt.style.css" type="text/css" rel="stylesheet">
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons"> <!--style="border-bottom: unset !important;"-->
                        <h3><span><?php echo get_menu_option(c_menu(), 'AQ') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <div style="display: flex">
                            <a href="<?php echo admin_url('wohnungen/wohnungen'); ?>"
                               class="btn btn-info pull-left display-block"><?php echo 'Erstellen'; ?></a>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'wohnungen'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('wohnungen', $title); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body ">
                        <div class="row" id="mieter-table">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="bold"><?php echo _l('filter_by'); ?></p>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('project', $project, array('id', 'name'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Projekt'), array()); ?>
                                    </div>
                                </div>
                                <div class="row"><!--
                                        <div class="col-md-2 leads-filter-column">
                                            <?php
                                    /*                                        $belegt = array(array('id' => '0', 'value' => 'Nein'), array('id' => '1', 'value' => 'Ja'));
                                                                            echo render_select('belegt', $belegt, array('value', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Belegt?'), array()); */ ?>
                                        </div>-->

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('strabe', $strabe, array('strabe', 'strabe'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Straße'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('hausnummer', $hausnummer, array('hausnummer', 'hausnummer'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Nr.'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('etage', $etage, array('etage', 'etage'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Etage'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('flugel', $flugel, array('flugel', 'flugel'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Flügel'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('schlaplatze', $schlaplatze, array('schlaplatze', 'schlaplatze'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Schlafplätze'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php
                                        $data = array(array('id' => -1, 'value' => 'Nein'), array('id' => 1, 'value' => 'Ja'));
                                        echo render_select('mobiliert', $data, array('id', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Möbliert'), array()); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading"/>
                        </div>

                        <button id="switchbtn" class="btn btn-success list">Visualisierung</button>
                        <div class="list-view switcher">
                            <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-wohnungen"><?php echo _l('Alle löschen'); ?></a>
                            <?php $this->load->view('admin/wohnungen/table_html'); ?>
                        </div>
                        <div class="visualisation-view switcher hide">
                             <?php $this->load->view('admin/visualisierung/shared'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<?php $this->load->view('admin/visualisierung/shared-js'); ?>
<style>
    .row-options-gantchart {
        color: white;
        text-align: center;
        padding: 4px 8px;
    }

    .row-options-gantchart a {
        color: white
    }

    .row-options-gantchart.enabled {
        background-color: #3E90B7;
    }

    .row-options-gantchart.disabled {
        background-color: gray;
        pointer-events: none;
        cursor: default;
    }

    .row-options-gantchart.disabled a {
        pointer-events: none;
        cursor: default;
    }

    .dataPanel{
        min-height: 120px;
    }
</style>
<script src="<?php echo base_url(); ?>assets/js/jquery.fn.gantt.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<?php
foreach ($aqs as $aq):
    $hisOccupations = $this->wohnungen_model->get_occupations($aq['id']);
    ?>
    <div class="modal fade" id="calendarmx<?= $aq['id'] ?>" tabindex="-1" role="dialog">
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
                                    <div id="calendar_dd<?= $aq['id'] ?>"></div>
                                </div>
                                <script>
                                    $(function () {
                                        var dd =  <?php echo json_encode($hisOccupations);?>;
                                        var data = [];
                                        var breackDay = [];
                                        for (let d of dd) {
                                            var stdate = moment(d.belegt_v, "YYYY-MM-DD").toDate();
                                            var b_mi = parseInt(d.break_days);
                                            var enddate = moment(d.belegt_b, "YYYY-MM-DD").toDate();

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

                                        $("#calendar_dd<?= $aq['id'] ?>").calendar({
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
<script>
    $(function () {
        $('#switchbtn').click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('list')) {
                $(this).text('Switch to table')
                $(this).addClass('ganttv').removeClass('list')
                $('.list-view,.list-view  .dataTable').addClass('hide');
                $('.visualisation-view , .visualisation-view .dataTable').removeClass('hide');
            } else {
                $(this).text('Visualisierung')
                $('.list-view,.list-view  .dataTable').removeClass('hide');
                $(this).addClass('list').removeClass('ganttv')
                $('.visualisation-view , .visualisation-view .dataTable').addClass('hide');
            }
        })

        $('table').on('click', '.row-options-gantchart a', function (event) {
            event.preventDefault();
            const dd = $(this).data('id');
            loadGantChart(dd)
        });

        function loadGantChart(dd) {
            $("#selector_dd").gantt({
                source: "<?php echo base_url(); ?>/admin/wohnungen/table1/" + dd,
                navigate: "scroll",
                scale: "days",
                maxScale: "months",
                minScale: "days",
                itemsPerPage: 500,
                scrollToToday: true,
                scrollToCustomDate: dd,
                onItemClick: function (data) {
                },
                onAddClick: function (dt, rowId) {
                },
                onRender: function () {
                    $('#gantmgre51').modal('show')
                }
            });


        }

    })
</script>
<div class="modal fade" id="gantmgre51" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo _l('Gantt'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel_s">
                            <div class="panel-body" style="overflow-x: auto;">
                                <div class="dt-loader hide"></div>
                                <div id="selector_dd"></div>
                            </div>
                            <script>
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
