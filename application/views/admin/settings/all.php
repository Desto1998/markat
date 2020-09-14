<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
  <?php echo form_open_multipart(
    (!isset($tab['update_url'])
    ? $this->uri->uri_string() . '?group=' . $tab['slug'] . ($this->input->get('tab') ? '&active_tab=' . $this->input->get('tab') : '')
    : $tab['update_url']),
    ['id' => 'settings-form', 'class' => isset($tab['update_url']) ? 'custom-update-url' : '']
);
    ?>
    <div class="row">
     <?php if ($this->session->flashdata('debug')) {
        ?>
       <div class="col-lg-12">
        <div class="alert alert-warning">
         <?php echo $this->session->flashdata('debug'); ?>
       </div>
     </div>
   <?php
    } ?>
   <div class="col-md-3">
    <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
      <?php
      $i = 0;
      foreach ($tabs as $group) {
          ?>
        <li<?php if ($i == 0) {
              echo " class='active'";
          } ?>>
        <a href="<?php echo admin_url('settings?group=' . $group['slug']); ?>" data-group="<?php echo $group['slug']; ?>">
          <?php echo $group['name']; ?></a>
        </li>
        <?php $i++;
      } ?>
      </ul>
      <div class="panel_s">
       <div class="panel-body">
        <div class="btn-bottom-toolbar text-right">
          <button type="submit" class="btn btn-info">
            <?php echo _l('settings_save'); ?>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="panel_s">
     <div class="panel-body">
      <?php hooks()->do_action('before_settings_group_view', $tab); ?>
      <?php $this->load->view($tab['view']) ?>
      <?php hooks()->do_action('after_settings_group_view', $tab); ?>
    </div>
  </div>
</div>
<div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
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
<?php hooks()->do_action('settings_tab_footer', $tab); ?>
</body>
</html>
