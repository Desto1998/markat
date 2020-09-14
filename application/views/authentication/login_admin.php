<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('authentication/includes/head.php'); ?>
<body class="login_admin"<?php if (is_rtl()) {
    echo ' dir="rtl"';
} ?>>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 authentication-form-wrapper">
            <div class="company-logo">
                <?php get_company_logo(); ?>
            </div>
            <div class="mtop40 authentication-form">
                <h1><?php echo _l('admin_auth_login_heading'); ?></h1>
                <?php $this->load->view('authentication/includes/alerts'); ?>
                <?php echo form_open($this->uri->uri_string()); ?>
                <?php echo validation_errors('<div class="alert alert-danger text-center">', '</div>'); ?>
                <?php hooks()->do_action('after_admin_login_form_start'); ?>
                <div class="form-group">
                    <label for="email" class="control-label"><?php echo _l('admin_auth_login_email'); ?></label>
                    <input type="email" id="email" name="email" class="form-control" autofocus="1">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label"><?php echo _l('admin_auth_login_password'); ?></label>
                    <input type="password" id="password" name="password" class="form-control"></div>
                <?php if (get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != '') { ?>
                    <div class="g-recaptcha" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>"></div>
                <?php } ?>
                <div class="checkbox">
                    <label for="remember">
                        <input type="checkbox" id="remember"
                               name="remember"> <?php echo _l('admin_auth_login_remember_me'); ?>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit"
                            class="btn btn-info btn-block"><?php echo _l('admin_auth_login_button'); ?></button>
                </div>
                <div class="form-group">
                    <a href="<?php echo admin_url('authentication/forgot_password'); ?>"><?php echo _l('admin_auth_login_fp'); ?></a>
                </div>

                <?php hooks()->do_action('before_admin_login_form_close'); ?>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-8 col-lg-offset-2">
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <?php if (!LIVE_VERSION): ?>
                <div id="fill-data" class="row text-center mtop40">
                    <div class="col-md-3">
                        <a href="#" class="btn admin btn-info display-block mright5 hidden-xs">
                            ADMINISTRATOR</a>
                    </div>
                    <div class="col-md-3">

                        <a href="#" class="btn auft btn-info display-block mright5 hidden-xs">
                            AUFTRAGGEBER</a>
                    </div>
                    <div class="col-md-3">

                        <a href="#" class="btn betr btn-info display-block mright5 hidden-xs">
                            Kundenbetreuer</a>
                    </div>
                    <div class="col-md-3">

                        <a href="#" class="btn miet btn-info display-block mright5 hidden-xs">
                            Mieter</a>
                    </div>
                </div>
                    <style>
                        #fill-data a {
                            text-transform: uppercase;
                        }
                    </style>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            $("#fill-data a").click(function (e) {
                                e.preventDefault();
                                var adminCred = {login: "ceo@markat.com", pwd: '12345678'};
                                var aufCred = {login: "", pwd: ''};
                                var betrCred = {login: "", pwd: ''};
                                var mietCred = {login: "", pwd: ''};

                                if ($(this).hasClass('admin')) {
                                    $('#email').val(adminCred.login);
                                    $('#password').val(adminCred.pwd);
                                }
                                if ($(this).hasClass('auft')) {

                                    $('#email').val(aufCred.login);
                                    $('#password').val(aufCred.pwd);
                                }
                                if ($(this).hasClass('betr')) {
                                    $('#email').val(betrCred.login);
                                    $('#password').val(betrCred.pwd);
                                }
                                if ($(this).hasClass('miet')) {
                                    $('#email').val(mietCred.login);
                                    $('#password').val(mietCred.pwd);
                                }
                            });
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>
</div>
</body>
</html>
