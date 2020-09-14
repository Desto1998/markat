<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show options for chat pusher in Setup->Settings->Chat settings
 */
$enabled = get_option('pusher_chat_enabled'); ?>
<div class="form-group">
    <label for="pusher_chat" class="control-label clearfix">
        <?php echo _l('chat_enable_option'); ?>
    </label>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_pusher_enable_chat" name="settings[pusher_chat_enabled]" value="1" <?= ($enabled == '1') ? ' checked' : '' ?>>
        <label for="y_opt_1_pusher_enable_chat"><?php echo _l('settings_yes'); ?></label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_pusher_enable_chat" name="settings[pusher_chat_enabled]" value="0" <?= ($enabled == '0') ? ' checked' : '' ?>>
        <label for="y_opt_2_pusher_enable_chat">
            <?php echo _l('settings_no'); ?>
        </label>
    </div>
</div>
<hr>

<!--  
* Show options for chat pusher in Setup->Settings->Chat settings
* get_option chat_client_enabled is by default 1
-->
<?php $chat_client_enabled = get_option('chat_client_enabled'); ?>
<div class="form-group">
    <label for="y_opt_1_chat_client_enabled" class="control-label clearfix">
        <?php echo _l('chat_client_module_enabled'); ?>
    </label>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_chat_client_enabled" name="settings[chat_client_enabled]" value="1" <?= ($chat_client_enabled == '1') ? ' checked' : '' ?>>
        <label for="y_opt_1_chat_client_enabled"><?php echo _l('settings_yes'); ?></label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_chat_client_enabled" name="settings[chat_client_enabled]" value="0" <?= ($chat_client_enabled == '0') ? ' checked' : '' ?>>
        <label for="y_opt_2_chat_client_enabled">
            <?php echo _l('settings_no'); ?>
        </label>
    </div>
</div>
<hr>

<!--  
* Show options for chat pusher in Setup->Settings->Chat settings
* get_option chat_members_can_create_groups is by default 1
-->
<?php $chat_members_can_create_groups = get_option('chat_members_can_create_groups');  ?>
<div class="form-group">
    <label for="y_opt_1_chat_members_can_create_groups" class="control-label clearfix">
        <?php echo _l('chat_staff_can_create_groups'); ?>
    </label>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_chat_members_can_create_groups" name="settings[chat_members_can_create_groups]" value="1" <?= ($chat_members_can_create_groups == '1') ? ' checked' : '' ?>>
        <label for="y_opt_1_chat_members_can_create_groups"><?php echo _l('settings_yes'); ?></label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_chat_members_can_create_groups" name="settings[chat_members_can_create_groups]" value="0" <?= ($chat_members_can_create_groups == '0') ? ' checked' : '' ?>>
        <label for="y_opt_2_chat_members_can_create_groups">
            <?php echo _l('settings_no'); ?>
        </label>
    </div>
</div>
<hr>

<!--  
* Show options for chat pusher in Setup->Settings->Chat settings
* get_option chat_staff_can_delete_messages is by default 1 
-->
<?php $can_delete = get_option('chat_staff_can_delete_messages');  ?>
<div class="form-group">
    <label for="pusher_chat" class="control-label clearfix">
        <?php echo _l('chat_allow_delete_messages'); ?>
    </label>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_chat_staff_can_delete_messages" name="settings[chat_staff_can_delete_messages]" value="1" <?= ($can_delete == '1') ? ' checked' : '' ?>>
        <label for="y_opt_1_chat_staff_can_delete_messages"><?php echo _l('settings_yes'); ?></label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_chat_staff_can_delete_messages" name="settings[chat_staff_can_delete_messages]" value="0" <?= ($can_delete == '0') ? ' checked' : '' ?>>
        <label for="y_opt_2_chat_staff_can_delete_messages">
            <?php echo _l('settings_no'); ?>
        </label>
    </div>
</div>
<hr>


<!--  
* Show options for chat pusher in Setup->Settings->Chat settings
* get_option chat_staff_can_delete_messages is by default 0
-->
<?php $notification_option = get_option('chat_desktop_messages_notifications');  ?>
<div class="form-group">
    <label for="pusher_chat" class="control-label clearfix">
        <?php echo _l('chat_show_desktop_messages_notifications'); ?>
    </label>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_chat_desktop_messages_notifications" name="settings[chat_desktop_messages_notifications]" value="1" <?= ($notification_option == '1') ? ' checked' : '' ?>>
        <label for="y_opt_1_chat_desktop_messages_notifications"><?php echo _l('settings_yes'); ?></label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_chat_desktop_messages_notifications" name="settings[chat_desktop_messages_notifications]" value="0" <?= ($notification_option == '0') ? ' checked' : '' ?>>
        <label for="y_opt_2_chat_desktop_messages_notifications">
            <?php echo _l('settings_no'); ?>
        </label>
    </div>
</div>