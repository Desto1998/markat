<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <h3><span><?php echo get_menu_option(c_menu(), 'Mieter') ?></span>
                            <?php if (has_permission('menu', '', 'edit')):
                                ?>
                                <a id="edit-menu" href="#"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?></h3>
                        <div style="display: flex">
                            <div><a href="<?php echo admin_url('mieter/mieter'); ?>"
                                    class="btn btn-info mright5 pull-left display-block"><?php echo 'Erstellen'; ?></a>

                                <a href="<?php echo admin_url('mieter/import'); ?>"
                                   class="btn btn-info bg-orange mright5 pull-left display-block"><?= get_menu_option('mieter', _l('Mieter')) . ' importieren'; ?></a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading"/>
                        <div class="col-md-4" style="padding: 0">
                            <h3 style="margin-top:3px !important;">
                                Gesamt:<b><?php echo total_rows(db_prefix() . 'mieters'); ?></b></h3>
                            <div class="panel_s" style="margin: 0 !important;">
                                <div class="panel-body" style="padding: 8px">
                                    <?= widget_status_stats('mieters', $title); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body">
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
                                <div class="row">
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('strabe', $strabe, array('strabe_m', 'strabe_m'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Straße'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('hausnummer', $hausnummer, array('hausnummer_m', 'hausnummer_m'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Nr.'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('etage', $etage, array('etage', 'etage'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Etage'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('flugel', $flugel, array('flugel', 'flugel'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Flügel'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('wohnungsnummer', $wohnungsnummer, array('wohnungsnummer', 'wohnungsnummer'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Wohnungsnummer'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('plz', $plz, array('plz', 'plz'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'PLZ'), array()); ?>
                                    </div>
                                    <div class="col-md-2 leads-filter-column">
                                        <?php echo render_select('stadt', $stadt, array('stadt', 'stadt'), '', '', array('data-width' => '100%', 'data-none-selected-text' => 'Stadt'), array()); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading"/>
                        </div>
                        <?php echo form_hidden('custom_view'); ?>
                        <div id="export-mieter">
                                <a href="#" class="bulk-actions-btn table-btn delete-all hide" id="sqdsqd"
                                   data-table=".table-mieter"><?php echo _l('Alle löschen'); ?></a>
                            <?php $this->load->view('admin/mieter/table_html'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contact_data"></div>
<?php init_tail(); ?>
<script>
    $(function () {

        var ContractsServerParams = {};
        $.each($('._hidden_inputs._filters input'), function () {
            ContractsServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
        });
        $('.table-mieter tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        //  initDataTable('.table-mieter', admin_url + 'mieter/table', undefined, undefined, ContractsServerParams,<?php echo hooks()->apply_filters('contracts_table_default_order', json_encode(array(0, 'desc'))); ?>);
        // Setup - add a text input to each footer cell

        /*        var otable = $('.table-mieter').DataTable();
                // Apply the search
                otable.columns().every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                });*/


    });

    function contact(client_id, contact_id) {
        if (typeof (contact_id) == 'undefined') {
            contact_id = '';
        }
        requestGet('clients/form_contact/' + client_id + '/' + contact_id).done(function (response) {
            $('#contact_data').html(response);
            $('#contact').modal({
                show: true,
                backdrop: 'static'
            });
            $('body').off('shown.bs.modal', '#contact');
            $('body').on('shown.bs.modal', '#contact', function () {
                if (contact_id == '') {
                    $('#contact').find('input[name="firstname"]').focus();
                }
            });
            init_selectpicker();
            init_datepicker();
            custom_fields_hyperlink();
            validate_contact_form();
        }).fail(function (error) {
            var response = JSON.parse(error.responseText);
            alert_float('danger', response.message);
        });
    }

    function validate_contact_form() {
        appValidateForm('#contact-form', {
            firstname: 'required',
            lastname: 'required',
            password: {
                required: {
                    depends: function (element) {

                        var $sentSetPassword = $('input[name="send_set_password_email"]');

                        if ($('#contact input[name="contactid"]').val() == '' && $sentSetPassword.prop('checked') == false) {
                            return true;
                        }
                    }
                }
            },
            email: {
                <?php if(hooks()->apply_filters('contact_email_required', "true") === "true"){ ?>
                required: true,
                <?php } ?>
                email: true,
                // Use this hook only if the contacts are not logging into the customers area and you are not using support tickets piping.
                <?php if(hooks()->apply_filters('contact_email_unique', "true") === "true"){ ?>
                remote: {
                    url: admin_url + "misc/contact_email_exists",
                    type: 'post',
                    data: {
                        email: function () {
                            return $('#contact input[name="email"]').val();
                        },
                        userid: function () {
                            return $('body').find('input[name="contactid"]').val();
                        }
                    }
                }
                <?php } ?>
            }
        }, contactFormHandler);
    }

    function contactFormHandler(form) {
        $('#contact input[name="is_primary"]').prop('disabled', false);

        $("#contact input[type=file]").each(function () {
            if ($(this).val() === "") {
                $(this).prop('disabled', true);
            }
        });

        var formURL = $(form).attr("action");
        var formData = new FormData($(form)[0]);

        $.ajax({
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            url: formURL
        }).done(function (response) {
            response = JSON.parse(response);
            if (response.success) {
                alert_float('success', response.message);
                if (typeof (response.is_individual) != 'undefined' && response.is_individual) {
                    $('.new-contact').addClass('disabled');
                    if (!$('.new-contact-wrapper')[0].hasAttribute('data-toggle')) {
                        $('.new-contact-wrapper').attr('data-toggle', 'tooltip');
                    }
                }
            }

            if ($.fn.DataTable.isDataTable('.table-contacts')) {
                $('.table-contacts').DataTable().ajax.reload(null, false);
            } else if ($.fn.DataTable.isDataTable('.table-all-contacts')) {
                $('.table-all-contacts').DataTable().ajax.reload(null, false);
            }

            if (response.proposal_warning && response.proposal_warning != false) {
                $('body').find('#contact_proposal_warning').removeClass('hide');
                $('body').find('#contact_update_proposals_emails').attr('data-original-email', response.original_email);
                $('#contact').animate({
                    scrollTop: 0
                }, 800);
            } else {
                $('#contact').modal('hide');
            }
        }).fail(function (error) {
            alert_float('danger', JSON.parse(error.responseText));
        });
        return false;
    }

</script>
</body>
</html>
