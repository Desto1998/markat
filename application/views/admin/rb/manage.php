<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Räumung/Beräumung') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                    </div>

                    <div class="panel-body">
                        <div class="row" id="rb-table">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="bold"><?php echo _l('filter_by'); ?></p>
                                    </div>
                                </div>
                                <div class="row"><!--
                                        <div class="col-md-2 leads-filter-column">
                                            <?php
                                    /*                                        $belegt = array(array('id' => '0', 'value' => 'Nein'), array('id' => '1', 'value' => 'Ja'));
                                                                            echo render_select('belegt', $belegt, array('value', 'value'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Belegt?'), array()); */ ?>
                                        </div>-->

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('name', $name, array('fullname', 'fullname'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Name')); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('strabe', $strabe, array('strabe_m', 'strabe_m'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Straße'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('schlaplatze', $schlaplatze, array('hausnummer_m', 'hausnummer_m'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Nr.'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('plz', $plz, array('plz', 'plz'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'PLZ'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('stadt', $stadt, array('stadt', 'stadt'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Stadt'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('project', $project, array('projektname', 'projektname'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Projekt'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_date_input('beraumung', '', '', array('data-width' => '100%', 'placeholder' => 'Beraumung'), array()); ?>
                                    </div>

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_date_input('baubeginn', '', '', array('data-width' => '100%', 'placeholder' => 'Baubeginn'), array()); ?>
                                    </div>

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_date_input('ruckraumung', '', '', array('data-width' => '100%', 'placeholder' => 'Ruckraumung'), array()); ?>
                                    </div>

                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_date_input('bauende', '', '', array('data-width' => '100%', 'placeholder' => 'Bauende'), array()); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading"/>
                        </div>
                        <div id="export-rb">
                            <?php $this->load->view('admin/rb/table_html'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="data_data"></div>
<?php
$datas = [];
$datas[] = array('id' => 1, 'value' => 'Umzugskarton');
$datas[] = array('id' => 2, 'value' => 'Bücherkarton');
$datas[] = array('id' => 3, 'value' => 'Kleiderbox');
$datas[] = array('id' => 4, 'value' => 'Packseide');
$datas[] = array('id' => 5, 'value' => 'Stretchfolie');
$datas[] = array('id' => 6, 'value' => 'Luftpolsterfolie');
$datas[] = array('id' => 7, 'value' => 'Bauplanen');
$datas[] = array('id' => 8, 'value' => 'Klebeband');
$datas[] = array('id' => 9, 'value' => 'Matratzenhülle');
$datas[] = array('id' => 10, 'value' => 'Bettensack');
$datas[] = array('id' => 11, 'value' => 'Kreppband');
?>
<div class="modal fade" id="createdocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Create Pdf
                </h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'createpdf-form')); ?>
                <input type="hidden" value="0" name="mieter" id="mieter">
                <div class="row field">
                    <div class="col-md-12">
                        <?php echo render_textarea('fo_arbeit', 'Folgende Arbeit') ?>
                    </div>
                </div>
                <div class="datacenter" id="datatable">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12">
                                    Options
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-2">bereits angeliefert</div>
                                <div class="col-md-2">mitzunehmen</div>
                                <div class="col-md-2">davon gebraucht</div>
                                <div class="col-md-2">davon zurück</div>
                                <div class="col-md-2">noch dort</div>
                                <div class="col-md-2">ungebr. zurück</div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php
                    $standards = get_option('standar_modal_doc');
                    if ($standards) {
                        $standards = unserialize($standards);
                    }
                    foreach ($datas as $k => $d):?>
                        <div class="row itemRow">
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><?= $d['value'] ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <?= render_input('x[x1][]', '', $standards ? $standards['x1'][$k] : '', 'number', array('min' => 1)) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= render_input('x[x2][]', '', $standards ? $standards['x2'][$k] : '', 'number', array('min' => 1)) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= render_input('x[x3][]', '', $standards ? $standards['x3'][$k] : '', 'number', array('min' => 1)) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= render_input('x[x4][]', '', $standards ? $standards['x4'][$k] : '', 'number', array('min' => 1)) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= render_input('x[x5][]', '', $standards ? $standards['x5'][$k] : '', 'number', array('min' => 1)) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= render_input('x[x6][]', '', $standards ? $standards['x6'][$k] : '', 'number', array('min' => 1)) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" id="savepdf"
                                    class="btn btn-info"><?php echo _l('submit'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 1;
    }

    input[type=number] {
        text-align: center
    }
</style>
<script>
    $(function () {

        $('#add-divb a').click(function (e) {
            e.preventDefault();
            if ($('.itemRow').length > 11)
                return;
            $cloned = $('.itemRow:last').clone();
            $cloned.insertBefore($('#add-divb'));
            $cloned.find('input').val('');
            $cloned.find('.dropdown-toggle').remove();
            init_selectpicker();

        });

        $('#savepdf').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                type: 'post',
                data: $("#createpdf-form").serialize(),
                url: admin_url + 'dokumente/ajax_create_doc',
                success: function (content) {
                    location.reload();
                }
            });
        })
        $('.table').on('click', '.createpdf-action', function (e) {
            e.preventDefault();
            const target = $(this).data('id');
            $("#createdocument #mieter").val(target);
            $('#createdocument').modal({
                backdrop: 'static',
                keyboard: false
            });
        })

        $('.table').on('click', '.data-act', function (e) {
            e.preventDefault();
            const mieter_id = $(this).data('id');
            const column = $(this).data('ucolumn');

            $.ajax({
                type: 'get',
                url: admin_url + 'rb/update_date/' + mieter_id + '/' + column,
                success: function (content) {
                    content = JSON.parse(content);
                    $("#data_data").html(content)
                    $("#data_data #update_date").modal('show');
                    init_datepicker();
                }
            });
        });

        $("#data_data").on('click', '#changedate', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                data: $("#change-date").serialize(),
                url: admin_url + 'rb/update_date',
                success: function (content) {
                    $("#data_data #update_date").modal('hide');
                    table_rb.DataTable().ajax.reload()
                        .columns.adjust()
                        .responsive.recalc();
                    init_datepicker();
                }
            });
        });

        var table_rb = $('.table-rb');
        // Add additional server params $_POST
        var LeadsServerParams = {
            "strabe": "[name='strabe']",
            "schlaplatze": "[name='schlaplatze']",
            "mobiliert": "[name='mobiliert']",
            "etage": "[name='etage']",
            "name": "[name='name']",
            "plz": "[name='plz']",
            "stadt": "[name='stadt']",
            "beraumung": "[name='beraumung']",
            "baubeginn": "[name='baubeginn']",
            "ruckraumung": "[name='ruckraumung']",
            "bauende": "[name='bauende']",
            "project": "[name='project']",
            "flugel": "[name='flugel']",
        };

        belegunTableServer = leadsTableNotSortable = [];
        var filterArray = [];
        var ContractsServerParams = {};

        $.each($('._hidden_inputs._filters input'), function () {
            ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });

        var _table_api = initDataTable(table_rb, admin_url + 'rb/table', undefined, undefined, LeadsServerParams, [0, 'desc'], filterArray);

        $.each(LeadsServerParams, function (i, obj) {
            $('#' + i).on('change', function () {
                table_rb.DataTable().ajax.reload()
                    .columns.adjust()
                    .responsive.recalc();
            });
        });
        //new $.fn.dataTable.FixedHeader( _table_api );


    });


</script>
</body>
</html>
