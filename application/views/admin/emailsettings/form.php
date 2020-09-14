<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#email_config" aria-controls="email_config" role="tab" data-toggle="tab"><?php echo _l('settings_smtp_settings_heading'); ?></a>
    </li>
    <li role="presentation">
        <a href="#email_queue" aria-controls="email_queue" role="tab" data-toggle="tab"><?php echo _l('email_queue'); ?></a>
    </li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="email_config">
        <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
        <input type="text" class="fake-autofill-field" name="fakeusernameremembered" value='' tabindex="-1" />
        <input type="password" class="fake-autofill-field" name="fakepasswordremembered" value='' tabindex="-1" />
        <h4 style="margin-top:-20px;"><?php echo _l('settings_smtp_settings_heading'); ?> <small><?php echo _l('settings_smtp_settings_subheading'); ?></small></h4>
        <hr />
        <div class="form-group">

            <label for="mail_engine"><?php echo _l('mail_engine'); ?></label><br />
            <div class="radio radio-inline radio-primary">
                <input type="radio" name="settings[mail_engine]" id="phpmailer" value="phpmailer" <?php if(get_option('mail_engine') == 'phpmailer'){echo 'checked';} ?>>
                <label for="phpmailer">PHPMailer</label>
            </div>

            <div class="radio radio-inline radio-primary">
                <input type="radio" name="settings[mail_engine]" id="codeigniter" value="codeigniter" <?php if(get_option('mail_engine') == 'codeigniter'){echo 'checked';} ?>>
                <label for="codeigniter">CodeIgniter</label>
            </div>
            <hr />
            <label for="email_protocol"><?php echo _l('email_protocol'); ?></label><br />
            <div class="radio radio-inline radio-primary">
                <input type="radio" name="settings[email_protocol]" id="smtp" value="smtp" <?php if(get_option('email_protocol') == 'smtp'){echo 'checked';} ?>>
                <label for="smtp">SMTP</label>
            </div>

            <div class="radio radio-inline radio-primary">
                <input type="radio" name="settings[email_protocol]" id="sendmail" value="sendmail" <?php if(get_option('email_protocol') == 'sendmail'){echo 'checked';} ?>>
                <label for="sendmail">Sendmail</label>
            </div>

            <div class="radio radio-inline radio-primary">
                <input type="radio" name="settings[email_protocol]" id="mail" value="mail" <?php if(get_option('email_protocol') == 'mail'){echo 'checked';} ?>>
                <label for="mail">Mail</label>
            </div>
        </div>
        <div class="smtp-fields<?php if(get_option('email_protocol') == 'mail'){echo ' hide'; } ?>">
            <div class="form-group mtop15">
                <label for="smtp_encryption"><?php echo _l('smtp_encryption'); ?></label><br />
                <select name="settings[smtp_encryption]" class="selectpicker" data-width="100%">
                    <option value="" <?php if(get_option('smtp_encryption') == ''){echo 'selected';} ?>><?php echo _l('smtp_encryption_none'); ?></option>
                    <option value="ssl" <?php if(get_option('smtp_encryption') == 'ssl'){echo 'selected';} ?>>SSL</option>
                    <option value="tls" <?php if(get_option('smtp_encryption') == 'tls'){echo 'selected';} ?>>TLS</option>
                </select>
            </div>
            <?php echo render_input('settings[smtp_host]','settings_email_host',get_option('smtp_host')); ?>
            <?php echo render_input('settings[smtp_port]','settings_email_port',get_option('smtp_port')); ?>
        </div>
        <?php echo render_input('settings[smtp_email]','settings_email',get_option('smtp_email')); ?>
        <div class="smtp-fields<?php if(get_option('email_protocol') == 'mail'){echo ' hide'; } ?>">
            <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('smtp_username_help'); ?>"></i>
            <?php echo render_input('settings[smtp_username]','smtp_username',get_option('smtp_username')); ?>
            <?php
            $ps = get_option('smtp_password');
            if(!empty($ps)){
                if(false == $this->encryption->decrypt($ps)){
                    $ps = $ps;
                } else {
                    $ps = $this->encryption->decrypt($ps);
                }
            }
            echo render_input('settings[smtp_password]','settings_email_password',$ps,'password',array('autocomplete'=>'off')); ?>
        </div>
        <?php echo render_input('settings[smtp_email_charset]','settings_email_charset',get_option('smtp_email_charset')); ?>
        <?php echo render_input('settings[bcc_emails]','bcc_all_emails',get_option('bcc_emails')); ?>
        <?php echo render_textarea('settings[email_signature]','settings_email_signature',get_option('email_signature'), ['data-entities-encode'=>'true']); ?>
        <hr />
        <?php echo render_textarea('settings[email_header]','email_header',get_option('email_header'),array('rows'=>15, 'data-entities-encode'=>'true')); ?>
        <?php echo render_textarea('settings[email_footer]','email_footer',get_option('email_footer'),array('rows'=>15, 'data-entities-encode'=>'true')); ?>
        <hr />
        <h4><?php echo _l('settings_send_test_email_heading'); ?></h4>
        <p class="text-muted"><?php echo _l('settings_send_test_email_subheading'); ?></p>
        <div class="form-group">
            <div class="input-group">
                <input type="email" class="form-control" name="test_email" data-ays-ignore="true" placeholder="<?php echo _l('settings_send_test_email_string'); ?>">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default test_email p7">Test</button>
                </div>
            </div>
        </div>

    </div>
    <div role="tabpanel" class="tab-pane" id="email_queue">
        <?php if(get_option('cron_has_run_from_cli') != '1') { ?>
            <div class="alert alert-danger">
                This feature requires a properly configured cron job. Before activating the feature, make sure that the <a href="<?php echo admin_url('settings?group=cronjob'); ?>">cron job</a> is configured as explanation in the documentation.
            </div>
        <?php } ?>
        <?php render_yes_no_option('email_queue_enabled','email_queue_enabled','To speed up the emailing process, the system will add the emails in queue and will send them via cron job, make sure that the cron job is properly configured in order to use this feature.'); ?>
        <hr />
        <?php render_yes_no_option('email_queue_skip_with_attachments','email_queue_skip_attachments','Most likely you will encounter problems with the email queue if the system needs to add big files to the queue. If you plan to use this option consult with your server administrator/hosting provider to increase the max_allowed_packet and wait_timeout options in your server config, otherwise when this option is set to yes the system won\'t add emails with attachments in the queue and will be sent immediately.'); ?>
    </div>
</div>

<?php init_tail(); ?>
<script>
    $(function(){
        var slug = "<?php echo $tab['slug']; ?>";
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var settingsForm = $('#settings-form');

            if(settingsForm.hasClass('custom-update-url')) {
                return;
            }

            var tab = $(this).attr('href').slice(1);
            settingsForm.attr('action','<?php echo site_url($this->uri->uri_string()); ?>?group='+slug+'&active_tab='+tab);
        });
        $('input[name="settings[email_protocol]"]').on('change',function(){
            if($(this).val() == 'mail'){
                $('.smtp-fields').addClass('hide');
            } else {
                $('.smtp-fields').removeClass('hide');
            }
        });
        $('.sms_gateway_active input').on('change',function(){
            if($(this).val() == '1') {
                $('body .sms_gateway_active').not($(this).parents('.sms_gateway_active')[0]).find('input[value="0"]').prop('checked',true);
            }
        });
        <?php if ($tab['slug'] == 'pusher') {
        ?>
        <?php if (get_option('desktop_notifications') == '1') {
        ?>
        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            $('#pusherHelper').html('<div class="alert alert-danger">Your browser does not support desktop notifications, please disable this option or use more modern browser.</div>');
        } else {
            if(Notification.permission == "denied"){
                $('#pusherHelper').html('<div class="alert alert-danger">Desktop notifications not allowed in browser settings, search on Google "How to allow desktop notifications for <?php echo $this->agent->browser(); ?>"</div>');
            }
        }
        <?php
        } ?>
        <?php if (get_option('pusher_realtime_notifications') == '0') {
        ?>
        $('input[name="settings[desktop_notifications]"]').prop('disabled',true);
        <?php
        } ?>
        <?php
        } ?>
        $('input[name="settings[pusher_realtime_notifications]"]').on('change',function(){
            if($(this).val() == '1'){
                $('input[name="settings[desktop_notifications]"]').prop('disabled',false);
            } else {
                $('input[name="settings[desktop_notifications]"]').prop('disabled',true);
                $('input[name="settings[desktop_notifications]"][value="0"]').prop('checked',true);
            }
        });
        $('.test_email').on('click', function() {
            var email = $('input[name="test_email"]').val();
            if (email != '') {
                $(this).attr('disabled', true);
                $.post(admin_url + 'emails/sent_smtp_test_email', {
                    test_email: email
                }).done(function(data) {
                    window.location.reload();
                });
            }
        });
    });
</script>

