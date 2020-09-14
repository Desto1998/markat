<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/gantt.style.css" type="text/css" rel="stylesheet">
<?php init_head(); ?>

<style>
    table th:first-child {
        width: 50px;
    }

    .github-corner:hover .octo-arm {
        animation: octocat-wave 560ms ease-in-out
    }

    @keyframes octocat-wave {
        0%, 100% {
            transform: rotate(0)
        }
        20%, 60% {
            transform: rotate(-25deg)
        }
        40%, 80% {
            transform: rotate(10deg)
        }
    }

    @media (max-width: 500px) {
        .github-corner:hover .octo-arm {
            animation: none
        }

        .github-corner .octo-arm {
            animation: octocat-wave 560ms ease-in-out
        }
    }

</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">

                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Reinigung') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                        </h3>

                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'occupations'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('occupations', $title); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="belegungsplan" class="panel-body ">
                        <div class="list-view switcher">
                            <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                               data-table=".table-belegungsplan"><?php echo _l('Alle löschen'); ?></a>
                            <?php $this->load->view('admin/belegungsplan/reinigung_table_html'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<script>

    function reinigungDateChange(id, obj) {
        $data = {"id": id, "reinigung_dt": obj.value}
        console.log($data);
        $.post(admin_url + 'reinigung/ajax_change_reinigung', $data).done(function (response) {
            console.log("respppp:", response);
            response = JSON.parse(response);
            alert_float('success', response.msg);
        });
    }

    $(function () {

        var table_reinigung = $('.table-reinigung');
        // Add additional server params $_POST
        var reinigungServerParams = {
            "hausnummer": "[name='hausnummer']",
            "strabe": "[name='strabe']",
            "schlaplatze": "[name='schlaplatze']",
            "mobiliert": "[name='mobiliert']",
            "etage": "[name='etage']",
            "flugel": "[name='flugel']",
        };

        var filterArray = [];
        var ContractsServerParams = {};
        $.each($('._hidden_inputs._filters input'), function () {
            ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });

        var _table_api = initDataTable(table_reinigung, admin_url + 'reinigung/table', [0], [0], reinigungServerParams, [1, 'desc'], filterArray);

        $.each(reinigungServerParams, function (i, obj) {
            $('#' + i).on('change', function () {
                table_reinigung.DataTable().ajax.reload()
                    .columns.adjust()
                    .responsive.recalc();
            });
        });

    });
</script>

</body>
</html>
