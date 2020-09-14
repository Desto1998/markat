  <div class="modal fade" id="chat_custom_modal" tabindex="-1" role="dialog">
    <form method="POST" id="members_form">
      <div class="modal-dialog" role="any">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?= isset($title) ? $title : ''  ?></h4>
          </div>
          <div class="modal-body">
            <h4 align="center" class="mbot20"><?= _l('chat_message_announcement'); ?></h4>
            <input type="hidden" class="ays-ignore" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="form-group">
              <label class="mtop20"><?= _l('chat_select_members_info'); ?></label>
              <select data-none-selected-text="<?= _l('chat_non_selected_membeer_text'); ?>" data-actions-box="true" id="members" name="members[]" multiple class="form-control">
                <?php
                if (is_array($staff) && !empty($staff)) {
                  foreach ($staff as $member) : if (get_staff_user_id() == $member['staffid']) continue;  ?>
                    <option data-subtext="<?= ($member['admin'] ? 'admin' : ''); ?>" data-icon="fa fa-user-o" value="<?= $member['staffid'] ?>"><?= $member['firstname'] . ' ' . $member['lastname']; ?>
                    </option>
                  <?php endforeach;
                } ?>
              </select>
              <label for="message" class="mtop20"><?= _l('chat_your_message_announce'); ?></label>
              <textarea style="max-width: 571px;" class="form-control" name="message" rows="6"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= _l('close'); ?></button>
            <button type="submit" class="btn btn-info"><?= _l('chat_send_button'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </form>
  </div><!-- /.modal -->


  <script>
    (function($) {
      "use strict";
      // Select picker settings
      $('#members').selectpicker({
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '400px'
      });

      // On submit event
      $('#members_form').on('submit', function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        // Send data to controller
        $.ajax({
          url: prchatSettings.sendStaffAnnouncement,
          method: "POST",
          data: formData,
          success: function(response) {
            if (response === 'true') {

              $('#members option:selected').each(function() {
                $(this).prop('selected', false);
              });

              $('#members').selectpicker('refresh');

              $('#chat_custom_modal').modal('hide');
              // If success hide modal 
              $('#chat_custom_modal').on('hidden.bs.modal', function() {
                $('#frame #contacts ul li:first').find('a').click();
              });

            }
          }
        });
      });
    })(jQuery);
  </script>