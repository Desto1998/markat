<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>

<div id="wrapper">

    <div class="content">


        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h4 class="customer-profile-group-heading" style="margin: 0">Neue AQ Fahrzeugliste</h4>

            </div>

        </div>

        <div class="row" id="cars">

            <div class="col-md-10 col-md-offset-1">

                <div class="panel_s" id="cars">

                    <div class="panel-body">

                        <?php echo form_open($this->uri->uri_string(), array('class' => 'dropzone zone-dsd', 'id' => 'cars-form')); ?>

                        <?php

                        if (isset($cars))
                            echo form_hidden('id', $cars->id);
                        ?>

                        <div class="row">

                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->marke : ''); ?>

                                <?php echo render_input('marke', 'Marke', $value); ?>

                            </div>


                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->modell : ''); ?>

                                <?php echo render_input('modell', 'Modell', $value); ?>

                            </div>


                        </div>

                        <div class="row">


                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->kennzeichen : ''); ?>

                                <?php echo render_input('kennzeichen', 'Kennzeichen', $value); ?>

                            </div>


                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->baujahr : ''); ?>

                                <?php echo render_input('baujahr', 'Baujahr', $value); ?>

                            </div>

                        </div>


                        <div class="row">


                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->kilometer : ''); ?>

                                <?php echo render_input('kilometer', 'Kilometer', $value); ?>

                            </div>


                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->user : ''); ?>

                                <?php echo render_select('user', $users, array('staffid', array('firstname', 'lastname')), 'Mitarbeiter', $value, array(), array(), '', '', false); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? $cars->tuv : ''); ?>

                                <?php echo render_date_input('tuv', 'TUV', _d($value)); ?>

                            </div>


                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? _d($cars->asu) : ''); ?>

                                <?php echo render_date_input('asu', 'ASU', _d($value)); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <?php $value = (isset($cars) ? _d($cars->inspektion) : ''); ?>

                                <?php echo render_date_input('inspektion', 'Inspektion', _d($value)); ?>

                            </div>


                            <div class="col-md-6">

                                <h3>Datien/Anh&auml;nge hochladen </h3>

                                <div class="row">

                                    <div class="col-md-12">

                                        <a href="#" class="btn btn-default add-post-attachments">

                                            <i data-toggle="tooltip"
                                               title="<?php echo _l('newsfeed_upload_tooltip'); ?>"

                                               class="fa fa-files-o"></i></a>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-12" id="cars-form-drop-zone">

                                        <div class="dz-message" data-dz-message><span></span></div>

                                        <div class="dropzone-previews mtop25"></div>

                                    </div>

                                </div>


                                <!-- <div class="panel-group">

                                     <div class="panel panel-default">

                                         <div class="panel-heading">

                                             <h4 class="panel-title">

                                                 <a data-toggle="collapse" href="#collapse1">Dokumentation</a>

                                             </h4>

                                         </div>-->

                                <!-- <div id="collapse1" class="panel-collapse collapse">

                                     <div class="panel-body">-->

                                <div class="row">

                                    <?php
                                    if (isset($cars)) {
                                        foreach ($cars->attachments as $k => $attachment) { ?>

                                            <?php ob_start(); ?>

                                            <div data-num="<?php echo $k; ?>"

                                                 data-cars-attachment-id="<?php echo $attachment['id']; ?>"

                                                 class="task-attachment-col col-md-4">

                                                <ul class="list-unstyled task-attachment-wrapper" data-placement="right"

                                                    data-toggle="tooltip"
                                                    data-title="<?php echo $attachment['file_name']; ?>">

                                                    <li class="mbot10 task-attachment<?php if (strtotime($attachment['dateadded']) >= strtotime('-16 hours')) {

                                                        echo ' highlight-bg';

                                                    } ?>">

                                                        <div class="mbot10 pull-right task-attachment-user">

                                                            <a href="#" class="pull-right"

                                                               onclick="remove_cars_attachment(this,<?php echo $attachment['id']; ?>); return false;">

                                                                <i class="fa fa fa-times"></i>

                                                            </a>

                                                            <?php

                                                            $externalPreview = false;

                                                            $is_image = false;

                                                            $path = get_upload_path_by_type('cars') . $cars->id . '/' . $attachment['file_name'];

                                                            $href_url = site_url('download/file/carsattachment/' . $attachment['attachment_key']);

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

                                                                <a href="<?php echo $href_url; ?>" target="_blank"
                                                                   class=""

                                                                   data-toggle="tooltip"

                                                                   data-title="<?php echo _l('open_in_dropbox'); ?>"><i

                                                                            class="fa fa-dropbox"
                                                                            aria-hidden="true"></i></a>

                                                            <?php } else if (!empty($attachment['external']) && $attachment['external'] == 'gdrive') { ?>

                                                                <a href="<?php echo $href_url; ?>" target="_blank"
                                                                   class=""

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

                                                            echo 'cars-attachment-no-preview';

                                                        } ?>">

                                                            <?php

                                                            // Not link on video previews because on click on the video is opening new tab

                                                            if (!$isHtml5Video){ ?>

                                                            <a href="<?php echo(!$externalPreview ? $href_url : $externalPreview); ?>"

                                                               target="_blank"<?php if ($is_image) { ?> data-lightbox="cars-attachment"<?php } ?>

                                                               class="<?php if ($isHtml5Video) {

                                                                   echo 'video-preview';

                                                               } ?>">

                                                                <?php } ?>

                                                                <?php if ($is_image) { ?>

                                                                    <img src="<?php echo $img_url; ?>"
                                                                         class="img img-responsive">

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

                                        }
                                    } ?>

                                </div>
                            </div>
                        </div>


                        <div class="text-right">

                            <!--<button type="submit" class="btn btn-info"><?php // echo _l('submit'); ?></button>-->
                            <button type="submit" id="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>

                        </div>

                        <?php echo form_close(); ?>

                    </div>

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

<?php if (isset($cars)) { ?>

    <!-- init table tasks -->

    <script>

        var cars_id = '<?php echo $cars->id; ?>';

    </script>

<?php } ?>

<script>

    appValidateForm($('#cars-form'), {marke: 'required', modell: 'required'});

</script>
<script src="http://162.144.65.120/~procopbn/markat/modules/prchat/assets/js/pr-chat.js?v=2.4.4"></script>
<script>

    //  appValidateForm('#mieter-form', {
    //     projektname: 'required',
    // }, heandler_form);

    // $('#mieter-form').on("submit", function (e) {
    //     e.preventDefault();
    //     e.stopPropagation();
    //     $(window).unbind('beforeunload');
    // });


    carsDropzone = new Dropzone("#cars-form-drop-zone", appCreateDropzoneOptions({

        clickable: '.add-post-attachments',

        url: admin_url + "cars/ajax_save", paramName: "files",

        autoProcessQueue: false,

        addRemoveLinks: true,

        uploadMultiple: true,

        parallelUploads: 40,

        maxFiles: 40,

        init: function () {

            carsDropzone = this;


            this.on('sending', function (file, xhr, formData) {

                // Append all form inputs to the formData Dropzone will POST

                var data = $('#cars-form').serializeArray();

                $.each(data, function (key, el) {

                    formData.append(el.name, el.value);

                });

            });


            this.on("success", function (file) {

            });

        },

        removedfile: function (file) {


            x = confirm('Do you want to delete?');

            if (!x) return false;

            if (cars_id != 0) {

                file.previewElement.remove();

            }

        },

        dragover: function (file) {

            $('#cars-form-drop-zone').addClass('dropzone-active');

        },

        complete: function (file) {

            console.log(file);

            $(this).prop('disabled', false);

            window.location.href = file.xhr.responseText;

        },

        drop: function (file) {

            $('#cars-form-drop-zone').removeClass('dropzone-active');

        }

    }));


    appValidateForm('#cars-form', {
    }, heandler_form);

    $('#cars-form').on("submit", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(window).unbind('beforeunload');
    });


    function heandler_form() {
//alert('fdffff')
        $('#cars-form #submit').prop('disabled', true);

        if (carsDropzone.getQueuedFiles().length > 0) {

            carsDropzone.processQueue();

        } else {
//alert(JSON.stringify($("#cars-form").serialize()))
            $.ajax({

                url: admin_url + "cars/ajax_save",

                data: $("#cars-form").serialize(),

                type: "POST",

                dataType: 'json',

                success: function (e) {

                    // alert(JSON.stringify(e))

                    window.location.href = e;

                    $(this).prop('disabled', false);

                },

                error: function (e) {
//alert(JSON.stringify(e))
                    window.location.href = e.responseText;

                    $(this).prop('disabled', false);

                }

            });

        }

    }


    // Get file extension

    function checkFileExt(filename) {

        filename = filename.toLowerCase();

        return filename.split('.').pop();

    }


    // Removes task single attachment
    function remove_cars_attachment(link, id) {
        if (confirm_delete()) {
            requestGetJSON('cars/delete_attach/' + id).done(function (response) {
                if (response) {
                    $('[data-cars-attachment-id="' + id + '"]').remove();
                }
            });
        }
    }

</script>
<?php
if (isset($cars)): ?>
    <script>
        var cars_id = '<?=$cars->id; ?>';
    </script>
<?php else: ?>
    <script>
        var cars_id = 0;
    </script>
<?php
endif;
?>

</body>

</html>

