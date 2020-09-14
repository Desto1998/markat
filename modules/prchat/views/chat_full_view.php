<?php
defined('BASEPATH') or exit('No direct script access allowed');
init_head();
?>
    <div id="wrapper" class="desktop_chat">
    <div id="frame">
        <div class="main_loader_init" id="main_loader_init">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <?php echo staff_profile_image($current_user->staffid, array('img', 'img-responsive', 'staff-profile-image-small', 'pull-left'), 'small', ['id' => 'profile-img']); ?>
                    <p>
                        <?php echo get_staff_full_name(); ?>
                    </p>
                </div>
            </div>
            <div class="connection_field">
                <i class="fa fa-wifi blink"></i>
            </div>
            <div id="search" style="width: <?= is_admin() ? '85%' : '100%'; ?>">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" id="search_field" placeholder="<?php echo _l('chat_search_chat_members'); ?>"
                       data-container="body" data-toggle="tooltip" data-placement="top"
                       title="<?php echo _l('chat_search'); ?>"/>
            </div>
            <?=
            (is_admin())
                ?
                '<div class="announcement" id="announcement">
      <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
      <i class="fa fa-cog i_settings" data-toggle="tooltip" title="' . _l('advanced_options') . '" aria-hidden="true"></i>
      </button>
      <ul class="dropdown-menu">
      <li class="i_announcement"><a href="javascript:void(0)"><i class="fa fa-bullhorn" aria-hidden="true"></i>' . _l('chat_message_announcement_text') . '</a></li>
      <li class="i_groups"><a href="javascript:void(0)"><i class="fa fa-users" aria-hidden="true"></i></i>' . _l('chat_message_groups_text') . '</a></li>
      </ul>
      </div>
      </div>'
                : '';
            ?>
            <ul class="nav nav-tabs chat_nav">
                <li class="active staff" style="<?= (!isClientsEnabled()) ? 'width:50%;' : ''; ?> "><a data-toggle="tab"
                                                                                                       href="#staff"><i
                                class="fa fa-user i_chat_navigation"></i><?= _l('chat_staff_text'); ?></a></li>
                <li class="groups events_disabled" style="<?= (!isClientsEnabled()) ? 'width:50%;' : ''; ?> "><a
                            data-toggle="tab" class="events_disabled" href="#groups"><i
                                class="fa fa-users i_chat_navigation"></i><?= _l('chat_groups_text'); ?></a></li>
                <?php if (isClientsEnabled()) : ?>
                    <li class="crm_clients"><a data-toggle="tab" class="events_disabled" href="#crm_clients"><i
                                    class="fa fa-address-book i_chat_navigation"></i><?= _l('chat_lang_clients'); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <div id="staff" class="tab-pane fade in active">
                    <div id="contacts">
                        <div id="bottom-bar">
                            <button id="switchTheme"><i class="fa fa-ioxhost" aria-hidden="true"></i> <span>
                  <div class="dropdown" id="theme_options">
                    <a href="#" class="dropbtn"><?php echo _l('chat_theme_name'); ?></a>
                    <div class="dropdown-content">
                      <a id="light" onClick="chatSwitchTheme('light')"
                         href="#"><?php echo _l('chat_theme_options_light'); ?></a>
                      <a id="dark" onClick="chatSwitchTheme('dark')"
                         href="#"><?php echo _l('chat_theme_options_dark'); ?></a>
                    </div>
                  </div>
                </span></button>
                            <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>
                                <span><?= _l('settings'); ?></span></button>
                        </div>
                        <ul class="chat_contacts_list">
                            <li class="contact">

                            </li>
                        </ul>
                    </div>
                </div>
                <div id="groups" class="tab-pane fade">
                    <div id="groups_container">
                        <ul class="chat_groups_list">
                        </ul>
                        <div id="bottom-bar">
                            <button id="add_group_btn"><i class="fa fa-plus" aria-hidden="true"></i>
                                <span><?= _l('chat_message_groups_text'); ?></span></button>
                        </div>
                    </div>
                </div>
                <?php if (isClientsEnabled()) : ?>
                    <div id="crm_clients" class="tab-pane fade">
                        <div id="clients_container">
                            <ul class="chat_clients_list">
                            </ul>
                            <div id="bottom-bar">
                                <button id="clients_show"><i class="fa fa-sliders" aria-hidden="true"></i>
                                    <span><?= _l('chat_lang_show_clients'); ?></span></button>
                                <button id="clients_hide"><i class="fa fa-sliders" aria-hidden="true"></i>
                                    <span><?= _l('chat_lang_hide_clients'); ?></span></button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="content">
            <div id="sharedFiles">
                <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                <div class="history_slider">
                </div>
            </div>
            <div class="chat_group_options">
            </div>
            <div class="contact-profile">
                <img src="" class="img img-responsive staff-profile-image-small pull-left" alt=""/>
                <p></p>
                <i class="fa fa-volume-up user_sound_icon" data-toggle="tooltip"
                   title="<?= _l('chat_sound_notifications'); ?>"></i>
                <div class="social-media mright15">
                    <i data-toggle="tooltip" data-container="body" title="<?php echo _l('chat_shared_files'); ?>"
                       data-placement="left" class="fa fa-share-alt" id="shared_user_files"></i>
                    <a href="" id="fa-skype" data-toggle="tooltip" data-container="body" class="mright5"
                       title="<?php echo _l('chat_call_on_skype'); ?>"><i class="fa fa-skype"
                                                                          aria-hidden="true"></i></a>
                    <a href="" id="fa-facebook" target="_blank" class="mright5"><i class="fa fa-facebook"
                                                                                   aria-hidden="true"></i></a>
                    <a href="" id="fa-linkedin" target="_blank" class="mright5"><i class="fa fa-linkedin"
                                                                                   aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="messages" onscroll="loadMessages(this)">
                <svg class="message_loader" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
                <span class="userIsTyping bounce" id="">
          <img src="<?php echo module_dir_url('prchat', 'assets/chat_implements/userIsTyping.gif'); ?>"/>
        </span>
                <ul>
                </ul>
            </div>
            <div class="group_messages" onscroll="loadGroupMessages(this)">
                <svg class="message_group_loader" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
                <div class="chat_group_messages">
                    <ul>
                    </ul>
                </div>
            </div>
            <?php if (isClientsEnabled()) : ?>
                <div class="client_messages" id="">
                    <svg class="message_loader" viewBox="0 0 50 50">
                        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                    </svg>
                    <span class="userIsTyping bounce" id="">
            <img src="<?php echo module_dir_url('prchat', 'assets/chat_implements/userIsTyping.gif'); ?>"/>
          </span>
                    <div class="chat_client_messages">
                        <ul>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Groups -->
            <form hidden enctype="multipart/form-data" name="fileForm" method="post"
                  onsubmit="uploadFileForm(this);return false;">
                <input type="file" class="file" name="userfile" required/>
                <input type="submit" name="submit" class="save" value="save"/>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                       value="<?php echo $this->security->get_csrf_hash(); ?>">
            </form>
            <form method="post" enctype="multipart/form-data" name="pusherMessagesForm" id="pusherMessagesForm"
                  onsubmit="return false;">
                <div class="message-input">
                    <div class="wrap">
                        <textarea type="text" disabled name="msg" class="chatbox ays-ignore"
                                  placeholder="<?= _l('chat_type_a_message'); ?>"></textarea>
                        <input type="hidden" class="ays-ignore from" name="from" value=""/>
                        <input type="hidden" class="ays-ignore to" name="to" value=""/>
                        <input type="hidden" class="ays-ignore typing" name="typing" value="false"/>
                        <input type="hidden" class="ays-ignore"
                               name="<?php echo $this->security->get_csrf_token_name(); ?>"
                               value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <i class="fa fa-plus-circle attachment fileUpload" data-container="body" data-toggle="tooltip"
                           title="<?php echo _l('chat_file_upload'); ?>" aria-hidden="true"></i>
                        <input type="hidden" class="ays-ignore has_newmessages" id="" value="false"/>
                        <button class="submit enterBtn" name="enterBtn"><i class="fa fa-paper-plane"
                                                                           aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
            <!-- Groups -->
            <form hidden enctype="multipart/form-data" name="groupFileForm" id="groupFileForm" method="post"
                  onsubmit="uploadGroupFileForm(this);return false;">
                <input type="file" class="file" name="userfile" required/>
                <input type="submit" name="submit" class="save" value="save"/>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                       value="<?php echo $this->security->get_csrf_hash(); ?>">
            </form>
            <form hidden method="post" enctype="multipart/form-data" name="groupMessagesForm" id="groupMessagesForm"
                  onsubmit="return false;">
                <div class="message-input group_msg_input">
                    <div class="wrap">
                        <textarea type="text" name="g_message" class="group_chatbox ays-ignore"
                                  placeholder="<?= _l('chat_type_a_message'); ?>"></textarea>
                        <input type="hidden" class="ays-ignore from" name="from" value=""/>
                        <input type="hidden" class="ays-ignore typing" name="typing" value="false"/>
                        <input type="hidden" class="ays-ignore"
                               name="<?php echo $this->security->get_csrf_token_name(); ?>"
                               value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <i class="fa fa-plus-circle attachment groupFileUpload" data-container="body"
                           data-toggle="tooltip" title="<?php echo _l('chat_file_upload'); ?>" aria-hidden="true"></i>
                        <button class="submit enterGroupBtn" name="enterGroupBtn"><i class="fa fa-paper-plane"
                                                                                     aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
            <!-- Clients -->
            <form hidden enctype="multipart/form-data" name="clientFileForm" id="clientFileForm" method="post"
                  onsubmit="uploadClientFileForm(this);return false;">
                <input type="file" class="file" name="userfile" required/>
                <input type="submit" name="submit" class="save" value="save"/>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                       value="<?php echo $this->security->get_csrf_hash(); ?>">
            </form>
            <form hidden method="post" enctype="multipart/form-data" name="clientMessagesForm" id="clientMessagesForm"
                  onsubmit="return false;">
                <div class="message-input client_msg_input">
                    <div class="wrap">
                        <textarea type="text" name="client_message" class="client_chatbox ays-ignore"
                                  placeholder="<?= _l('chat_type_a_message'); ?>"></textarea>
                        <input type="hidden" class="ays-ignore from" name="from" value=""/>
                        <input type="hidden" class="ays-ignore to" name="to" value=""/>
                        <input type="hidden" class="ays-ignore typing" name="typing" value="false"/>
                        <input type="hidden" class="ays-ignore"
                               name="<?php echo $this->security->get_csrf_token_name(); ?>"
                               value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <i class="fa fa-plus-circle attachment clientFileUpload" data-container="body"
                           data-toggle="tooltip" title="<?php echo _l('chat_file_upload'); ?>" aria-hidden="true"></i>
                        <input type="hidden" class="ays-ignore invisibleUnread" value=""/>
                        <button class="submit enterClientBtn" name="enterClientBtn"><i class="fa fa-paper-plane"
                                                                                       aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal_container"></div>
<?php init_tail(); ?>
    <!-- Chat settings -->
<?php include('modules/prchat/assets/module_includes/chat_settings.php'); ?>
<?php require('modules/prchat/assets/module_includes/mutual_and_helper_functions.php'); ?>
    <!-- Groups Settings and initializing -->
    <script>
        if (localStorage.chat_theme_name) {
            $('body').addClass('chat_' + localStorage.chat_theme_name);
        }

        var wentOffline, wentOnline;
        window.addEventListener('online', handleConnectionChange);
        window.addEventListener('offline', handleConnectionChange);
        monitorWindowActivity();

        /*---------------* Main first thing get users/staff from database *---------------*/
        var users = $.get(prchatSettings.usersList);

        var offsetPush = 0;
        var groupOffsetPush = 0;
        var endOfScroll = false;
        var groupEndOfScroll = false;
        var friendUsername = '';
        var unreadMessages = '';
        var pusherKey = "<?= get_option('pusher_app_key') ?>";
        var appCluster = "<?= get_option('pusher_cluster') ?>";
        var staffFullName = "<?= get_staff_full_name(); ?>";
        var userSessionId = "<?= get_staff_user_id(); ?>";
        var isAdmin = app.user_is_admin;
        var staffCanCreateGroups = "<?= get_option('chat_members_can_create_groups'); ?>";
        var checkforNewMessages = prchatSettings.getUnread;

        var sound_user_id = '';

        if (staffCanCreateGroups === '0' && !isAdmin) {
            $('#add_group_btn').remove();
        }

        /*---------------* Handles input form sending *---------------*/
        $('#frame').on('click', '.fileUpload', function () {
            $('#frame').find('form[name="fileForm"] input:first').click();
        });

        $('#frame').on('click', '.groupFileUpload', function () {
            $('#frame').find('form[name="groupFileForm"] input:first').click();
        });

        $('#frame').on('change', 'input[type=file]', function () {
            $(this).parent('form').submit();
        });

        // Handles file form upload  for staff to staff
        function uploadFileForm(form) {
            var formData = new FormData();
            var fileForm = $(form).children('input[type=file]')[0].files[0];
            var sentTo = $('li.contact.active').attr('id');
            var token_name = $(form).children('input[name=csrf_token_name]').val();
            var formId = $(form).attr('id');

            formData.append('userfile', fileForm);
            formData.append('send_to', sentTo);
            formData.append('send_from', userSessionId);
            formData.append('csrf_token_name', token_name);

            $.ajax({
                type: 'POST',
                url: prchatSettings.uploadMethod,
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    if ($('.chat-module-loader').length == 0) {
                        $('.content').prepend('<div class="chat-module-loader"><div></div><div></div><div></div></div>');
                    } else {
                        $('.content .chat-module-loader').fadeIn();
                    }
                    var Regex = new RegExp('\[~%:\()@]');
                    if (Regex.test(fileForm.name)) {
                        alert_float('warning', '<?php echo _l('chat_permitted_files') ?>');
                        $('.content .chat-module-loader').remove();
                        return false;
                    }
                },
                success: function (r) {
                    if (!r.error) {
                        var uploadSend = $.Event("keypress", {
                            which: 13
                        });
                        var basePath = "<?php echo base_url('modules/prchat/uploads/'); ?>";
                        $('#frame textarea.chatbox').val(basePath + r.upload_data.file_name);
                        setTimeout(function () {
                            if ($('#frame textarea.chatbox').trigger(uploadSend)) {
                                alert_float('info', 'File ' + r.upload_data.file_name + ' sent.');
                                $('.content .chat-module-loader').fadeOut();
                            }
                        }, 100);
                        getSharedFiles(userSessionId, sentTo);
                    } else {
                        $('.content .chat-module-loader').fadeOut();
                        alert_float('danger', r.error);
                    }
                }
            });
            $('form#' + formId).trigger("reset");
        }

        /*---------------* Check for messages history and append to main chat window *---------------*/
        function loadMessages(el) {
            var pos = $(el).scrollTop();
            var id = $(el).attr("id");
            var to = $('#contacts ul li.contact').children('a.active_chat').attr('id');
            var from = userSessionId;

            $('#frame .messages').find('.message_loader').show();


            if (pos == 0 && offsetPush >= 10) {

                $.get(prchatSettings.getMessages, {
                    from: from,
                    to: to,
                    offset: offsetPush,
                })
                    .done(function (message) {
                        message = JSON.parse(message);
                        if (Array.isArray(message) == false) {
                            endOfScroll = true;
                            $('#frame .messages').find('.message_loader').hide();
                            if ($(el).hasScrollBar() && endOfScroll == true) {
                                prchat_setNoMoreMessages();
                            }
                        } else {
                            offsetPush += 10;
                        }

                        $(message).each(function (key, value) {
                            value.message = emojify.replace(value.message);
                            var element = $('.messages#id_' + to).find('ul');
                            if (value.is_deleted == 1) {
                                value.message = '<span>' + prchatSettings.messageIsDeleted + '</span>';
                            } else {
                                value.message = emojify.replace(value.message);
                            }
                            if (value.reciever_id == from) {
                                element.prepend('<li class="replies"><img class="friendProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '" data-toggle="tooltip" data-container="body" data-placement="right" title="' + value.time_sent_formatted + '"/><p class="friend">' + value.message + '</p></li>');
                            } else {
                                element.prepend('<li class="sent" id="' + value.id + '"><img class="myProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '" data-toggle="tooltip" data-container="body" data-placement="left" title="' + value.time_sent_formatted + '"/><p class="you" id="msg_' + value.id + '">' + value.message + '</p></li>');
                                <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
                                if (value.is_deleted == 0) {
                                    $('#msg_' + value.id).tooltipster({
                                        content: $("<span id='" + value.id + "' class='prchat_message_delete' ontouchstart='delete_chat_message(this)' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                                        interactive: true,
                                        side: 'left'
                                    });
                                }
                                <?php endif; ?>
                            }
                        });
                        if (endOfScroll == false) {
                            $(el).scrollTop(200);
                        }
                    });
                activateLoader();
            }
        }

        /*---------------* Put prchatSettings.debug for debug mode for Pusher *---------------*/
        if (prchatSettings.debug) {
            try {
                Pusher.log = function (message) {
                    if (window.console && window.console.log) {
                        window.console.log(message);
                    }
                };
            } catch (e) {
                if (e instanceof ReferenceError) {
                    alert_float('danger', e);
                }
            }
        }


        /*---------------* Init pusher library, and register *---------------*/
        var pusher = new Pusher(pusherKey, {
            authEndpoint: prchatSettings.pusherAuthentication,
            authTransport: 'jsonp',
            'cluster': appCluster,
        });

        /*---------------* Pusher Trigger accessing channel *---------------*/
        var presenceChannel = pusher.subscribe('presence-mychanel');
        var groupChannels = pusher.subscribe('group-chat');

        pusher.config.unavailable_timeout = 5000;
        pusher.connection.bind('state_change', function (states) {
            var prevState = states.previous;
            var currState = states.current;
            var conn_tracker = $('.connection_field');
            if (currState == 'unavailable') {
                conn_tracker.fadeIn();
                conn_tracker.children('i.fa-wifi').fadeIn();
                conn_tracker.css('background', '#f03d25');
            } else if (currState == 'connected') {
                if (conn_tracker.is(':visible')) {
                    conn_tracker.children('i.fa-wifi').removeClass('blink');
                    conn_tracker.css('background', '#04cc04', function () {
                        conn_tracker.fadeOut(2000);
                    });
                }
            }
        });

        /*---------------* Pusher Trigger subscription succeeded *---------------*/
        presenceChannel.bind('pusher:subscription_succeeded', function (members) {
            chatMemberUpdate(members);
            users.then(function () {
                if (localStorage.staff_to_redirect) {
                    $('#contacts a#' + localStorage.staff_to_redirect).click();
                    localStorage.staff_to_redirect = '';
                } else {
                    setTimeout(function () {
                        $('#frame #sidepanel ul.nav.nav-tabs li.staff.active a').click();
                    }, 600);
                }
            });
        });

        /*---------------* Pusher Trigger user connected *---------------*/
        presenceChannel.bind('pusher:member_added', function (member) {
            addChatMember(member);
            if (member.info.justLoggedIn) {
                var message_selector = $('#contacts .contact a#' + member.id).find('.wrap .meta .preview');
                var old_message_content = message_selector.html();
                message_selector.html('<strong class="contact_role">' + member.info.name + "<?php echo _l('chat_user_is_online'); ?>" + '</strong>');
                setTimeout(function () {
                    message_selector.html(old_message_content);
                }, 7000);
                $.notify('', {
                    'title': app.lang.new_notification,
                    'body': member.info.name + ' ' + prchatSettings.hasComeOnlineText,
                    'requireInteraction': true,
                    'icon': $('#header').find('img').attr('src'),
                    'tag': 'user-join-' + member.id,
                    'closeTime': 5000,
                });
            }
        });

        /*---------------* Pusher Trigger user logout *---------------*/
        presenceChannel.bind('pusher:member_removed', function (members) {
            removeChatMember(members);
        });

        var pendingRemoves = [];

        /*---------------* New chat members tracking / removing *---------------*/
        function addChatMember(member) {
            var pendingRemoveTimeout = pendingRemoves[member.id];
            $('a#' + member.id + ' .wrap span').addClass('online').removeClass('offline');
            if (member.info.justLoggedIn == true) {
                $('.liveUsers').remove();
                $("#menu .menu-item-prchat span").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (presenceChannel.members.count - 1) + '</span>');
                appendMemberToTop(member.id);
            } else {
                if ($('#contacts li.contact#' + member.id).find('.unread-notifications').attr('data-badge') != 0) {
                    appendMemberToTop(member.id);
                }
            }
            if (pendingRemoveTimeout) {
                clearTimeout(pendingRemoveTimeout);
            }
        }

        /*---------------* New chat members tracking / removing *---------------*/
        function removeChatMember(members) {
            pendingRemoves[members.id] = setTimeout(function () {
                if (presenceChannel.members.count > 0) {
                    $('.liveUsers').remove();
                    $("#menu .menu-item-prchat span").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (presenceChannel.members.count - 1) + '</span>');
                }
                $('a#' + members.id + ' .wrap span').addClass('online').removeClass('offline');
                chatMemberUpdate(members);
            }, 5000);
        }

        /*---------------* Append member to top of sidebar after logged in *---------------*/
        function appendMemberToTop(member) {
            var $cloned = $('#contacts li.contact#' + member).clone();
            $('#contacts li.contact#' + member).remove();
            $cloned.prependTo('#contacts ul')
        }

        /*---------------* Bind the 'send-event' & update the chat box message log *---------------*/
        presenceChannel.bind('send-event', function (data) {
            if (data.global) {
                data.message = "<?= '<strong>' . _l('chat_message_announce') . '</strong>'; ?>" + data.message;
            }
            $('#frame .messages').find('span.userIsTyping').fadeOut(500);
            if (data.last_insert_id) {
                $('.messages').find('li.sent .you#' + userSessionId).attr('id', 'msg_' + data.last_insert_id)
                $('.messages').find('li.sent#' + userSessionId).attr('id', data.last_insert_id)
            }
            <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
            $('li#' + data.last_insert_id + ' #msg_' + data.last_insert_id).tooltipster({
                content: $("<span id='" + data.last_insert_id + "' class='prchat_message_delete' ontouchstart='delete_chat_message(this)' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                interactive: true,
                side: 'left'
            });
            <?php endif; ?>

            if (presenceChannel.members.me.id == data.to && data.from != presenceChannel.members.me.id) {
                $('.has_newmessages').val('true').attr('id', data.from);
                data.message = createTextLinks_(emojify.replace(data.message));
                $('.messages#id_' + data.from + ' ul').append('<li class="replies"><img class="friendProfilePic" src="' + fetchUserAvatar(data.from, data.sender_image) + '"/><p class="friend">' + data.message + '</p></li>');
                $('#contacts .contact a#' + data.from).find('.wrap .meta .preview').html(data.message);
                $('#contacts .contact a#' + data.from).find('.wrap .meta .pull-right.time_ago').html(moment().format('hh:mm A'));
                initUserSound(data);
                if ($('.messages').hasScrollBar()) {
                    scroll_event();
                }
            }

            if (presenceChannel.members.me.id == data.to) {
                scroll_event();
                var old_data = emojify.replace(data.message);
                data.message = escapeHtml(data.message);

                var firstname = presenceChannel.members.members[data.from].name.replace(/ .*/, '');

                if (data.message.includes('class="prchat_convertedImage"')) {
                    data.message = '<p class="tb">' + firstname + ' ' + '<?php echo _l('chat_new_file_uploaded'); ?></p>';
                }

                if (data.message.includes('data-lity target="blank" href')) {
                    data.message = '<p class="tb">' + firstname + ' ' + '<?php echo _l('chat_new_link_shared'); ?></p>';
                }

                var truncated_message = '';
                if (old_data.includes('emoji') && !old_data.includes('href')) {
                    $('#contacts .contact a#' + data.from).find('.wrap .meta .preview').html(old_data);
                    scroll_event();
                    return false;
                }

                if (!data.message.includes('class="tb"')) {
                    truncated_message = data.message.trunc(36);
                } else {
                    truncated_message = data.message.trunc(46);
                }

                if ($(window).width() > 733) {
                    $('#contacts .contact a#' + data.from).find('.unread-notifications').hide();
                }
                $('#contacts .contact a#' + data.from).find('.wrap .meta .preview').html(truncated_message);
            }

        });

        /*---------------* Detect when a user is typing a message *---------------*/
        presenceChannel.bind('typing-event', function (data) {
            if (
                presenceChannel.members.me.id == data.to &&
                data.from != presenceChannel.members.me.id &&
                data.message == 'true'
            ) {
                $('#frame .messages')
                    .find('span.userIsTyping#' + data.from)
                    .fadeIn(500);
            } else if (
                presenceChannel.members.me.id == data.to &&
                data.from != presenceChannel.members.me.id &&
                data.message == 'null'
            ) {
                $('#frame .messages')
                    .find('span.userIsTyping#' + data.from)
                    .fadeOut(500);
            }
        });

        /*---------------* Trigger notification popup increment*---------------*/
        presenceChannel.bind('notify-event', function (data) {
            <?php if ($chat_desktop_messages_notifications == '1') :  ?>
            var messagesIndentifier = $('#frame .content .messages#id_' + data.from);
            if (data.from !== userSessionId && data.to == userSessionId && !messagesIndentifier.is(':visible')) {
                $.notify('', {
                    'title': data.from_name,
                    'body': data.message,
                    'requireInteraction': false,
                    'icon': fetchUserAvatar(data.from, data.sender_image),
                    'tag': 'user-message-' + data.from,
                    'closeTime': 4000,
                });
            }
            <?php endif; ?>

            if ($(window).width() < 733) {
                if (presenceChannel.members.me.id == data.to && data.from != presenceChannel.members.me.id) {
                    var notiBox = $('body').find('li.contact#' + data.from + ' a#' + data.from);
                    if (!$(notiBox).hasClass("active_chat")) {
                        $(notiBox).find('img').addClass('shaking');
                        var notification = parseInt($(notiBox).find('.unread-notifications#' + data.from).attr('data-badge'));
                        var badge = $(notiBox).find('.unread-notifications#' + data.from);
                        badge.attr('data-badge', notification + 1);
                        $(notiBox).find('.unread-notifications#' + data.from).show();
                    }
                    delay(function () {
                        $(notiBox).find('img').removeClass('shaking');
                    }, 600);
                }
            }
        });

        /*---------------* On click send message button trigger post message *---------------*/
        $('#frame').on('click', '.enterBtn, .enterGroupBtn, .enterClientBtn', function (e) {
            var eventEnter = $.Event("keypress", {
                which: 13
            });
            if (e.target.name == 'enterBtn') {
                $('#frame').find('.chatbox').trigger(eventEnter);
            } else if (e.target.name == 'enterGroupBtn') {
                $('#frame').find('.group_chatbox').trigger(eventEnter);
            } else if (e.target.name == 'enterClientBtn') {
                $('#frame').find('.client_chatbox').trigger(eventEnter);
            }
        });

        /*---------------* chatMemberUpdate() place & update users on user page, unread messages notifications *---------------*/
        function chatMemberUpdate() {
            users.then(function (data) {
                var offlineUser = '';
                var onlineUser = '';
                data = JSON.parse(data);
                $('.chatbox').prop('disabled', '');
                $.each(data, function (user_id, value) {
                    if (value.staffid != presenceChannel.members.me.id) {
                        var user = presenceChannel.members.get(value.staffid);
                        if (value.message == undefined) value.message = prchatSettings.sayHiText + ' ' + strCapitalize(value.firstname + ' ' + value.lastname);
                        if (value.time_sent_formatted == undefined) value.time_sent_formatted = '';

                        console.log(user);
                        console.log(value);

                        if (user != null) {
                            onlineUser += '<li class="contact" id="' + value.staffid + '" data-toggle="tooltip" data-container="body" title="<?php echo _l('chat_user_active_now'); ?>">';
                            onlineUser += '<a href="#' + value.staffid + '" id="' + value.staffid + '" class="on"><div class="wrap"><span class="online">';
                            onlineUser += '</span><img src="' + fetchUserAvatar(value.staffid, value.profile_image) + '" class="imgFriend" /><div class="meta"><p role="' + value.admin + '" class="name">' + strCapitalize(value.firstname + ' ' + value.lastname) + '</p><social_info skype="' + value.skype + '" facebook="' + value.facebook + '" linkedin="' + value.linkedin + '"></social_info>';
                            onlineUser += '<p class="preview">' + value.message + '</p><p class="pull-right time_ago">' + value.time_sent_formatted + '</p>';
                            onlineUser += '</div></div>';
                            onlineUser += '<span class="unread-notifications" id="' + value.staffid + '" data-badge="0"></span></a></li>';
                            if (presenceChannel.members.count > 0) {
                                $('.liveUsers').remove();
                                $("#menu .menu-item-prchat span").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (' ' + presenceChannel.members.count - 1) + '</span>');
                            }
                        } else {
                            offlineUser += '<li class="contact" id="' + value.staffid + '"';
                            var lastLoginText = '';
                            if (value.last_login) {
                                lastLoginText = moment(value.last_login, "YYYYMMDD h:mm:ss").fromNow();
                            } else {
                                lastLoginText = 'Never';
                            }
                            offlineUser += ' data-toggle="tooltip" data-container="body" title="<?php echo _l('chat_last_seen'); ?>: ' + lastLoginText + '">';
                            offlineUser += '<a href="#' + value.staffid + '" id="' + value.staffid + '" class="off"><div class="wrap"><span class="offline"></span>';
                            offlineUser += '<img src="' + fetchUserAvatar(value.staffid, value.profile_image) + '" class="imgFriend" /><div class="meta"><p role="' + value.admin + '" class="name">' + strCapitalize(value.firstname + ' ' + value.lastname) + '</p>';
                            offlineUser += '<p class="preview">' + value.message + '</p><p class="pull-right time_ago">' + value.time_sent_formatted + '</p><social_info skype="' + value.skype + '" facebook="' + value.facebook + '" linkedin="' + value.linkedin + '"></social_info>';
                            offlineUser += '</div></div><span class="unread-notifications" id="' + value.staffid + '" data-badge="0"></span></a></li>';
                        }
                    }
                });
                $('#frame #contacts ul').html('');
                $('#frame #contacts ul').prepend(onlineUser + offlineUser);

                var newUnreadMessages = JSON.parse(checkforNewMessages);
                if (!checkforNewMessages.includes('false')) {
                    $.each(newUnreadMessages, function (i, sender) {
                        notifications = $('#contacts li a#' + sender.sender_id).find('.unread-notifications#' + sender.sender_id);
                        if (notifications.length) {
                            notifications.attr('data-badge', sender.count_messages);
                            notifications.show();
                        }
                    });
                }
                return false;
            });
        }

        /*---------------* Trigger click on user & create chat box and check for messages *---------------*/
        $('#frame #contacts .chat_contacts_list').on("click", "li.contact a", function (event) {
            var obj = $(this);
            var id = obj.attr('id').replace('id_', '');
            var contact_selector = $('#contacts a#' + id);

            // Handle unread messages
            if ($('.has_newmessages').attr('id') == id && $('.has_newmessages').val() == 'true' ||
                $(this).find('.unread-notifications#' + id).attr('data-badge') > 0) {
                updateLatestMessages(id);
            }

            $('.has_newmessages').val('false').attr('id', '');

            $('.group_members_inline').remove();

            var currentSoundMembers = JSON.parse(localStorage.getItem("soundDisabledMembers"));
            (currentSoundMembers.includes(id)) ?
                $('.user_sound_icon').removeClass('fa-volume-up').addClass('fa-volume-off') : $('.user_sound_icon').removeClass('fa-volume-off').addClass('fa-volume-up');


            var contact_image = $('#frame .contact-profile img.staff-profile-image-small');
            if (contact_image.is(':hidden')) {
                contact_image.show();
            }
            endOfScroll = false;
            offsetPush = 0;
            $('#frame .chatbox').val('');

            $('#contacts li a').removeClass('active_chat');
            $('#contacts .contact').removeClass('active');
            contact_selector.parent('.contact').addClass('active');
            $(this).addClass('active_chat');
            if (contact_selector.parent('.contact').find('.tb')) {
                contact_selector.parent('.contact').find('.tb').css({
                    'font-weight': 'normal',
                    'color': 'rgba(153, 153, 153, 1)'
                });
            }
            createChatBox(obj);

            if ($('#search_field').val() !== '') {
                clearSearchValues();
            }

            if ($(this).find('.unread-notifications#' + id).attr('data-badge') > 0) {
                updateUnreadMessages($(this));
                setTimeout(function () {
                    obj.find('.unread-notifications#' + id).attr('data-badge', '0').hide();
                }, 1000);
            }
        });

        /*---------------* Creating chat box from the html template to the DOM *---------------*/
        var createChatBoxRequest = null;

        function createChatBox(obj) {
            $('.messages ul').html('');
            var id = obj.attr('href');
            var fullName = obj.find('.meta').children('p:first-child').text();
            var contactRole = obj.find('.meta').children('p:first-child').attr('role');

            var contact_id = id.replace("#", "");
            id = id.replace("#", "id_");
            $('.messages').find('span.userIsTyping').attr('id', contact_id);

            $('#frame .content .contact-profile p').html(fullName + '<br><a target="_blank" href="' + site_url + 'admin/profile/' + contact_id + '"><small class="contact_role"></small></a>');
            $('#frame .content .contact-profile .user_sound_icon').attr('data-sound_user_id', contact_id);
            $('.group_members_inline').remove();

            checkContactRole(contactRole);

            var currentActiveChatWindow = obj.hasClass('active');

            var dfd = $.Deferred();
            var promise = dfd.promise();

            if (!currentActiveChatWindow) {
                if (createChatBoxRequest) {
                    createChatBoxRequest.abort();
                }
                createChatBoxRequest = $.get(prchatSettings.getMessages, {
                    from: userSessionId,
                    to: contact_id,
                    offset: 0,
                    limit: 20
                })
                    .done(function (r) {
                        offsetPush = 10;

                        r = JSON.parse(r);

                        message = r;

                        offsetPush += 10;
                        dfd.resolve(message);

                    }).always(function () {
                        if ($("#no_messages").length) {
                            $("#no_messages").remove();
                        }
                        createChatBoxRequest = null;
                    });
            } else {
                dfd.resolve([]);
            }

            /*---------------* After users are fetched from database -> continue with loading *---------------*/
            promise.then(function (message) {
                var sliderimg = obj.find('img').prop("currentSrc");
                $('#frame .content .contact-profile img').prop("src", sliderimg);

                $('#pusherMessagesForm').attr('id', id);
                $('.messages#' + id).parent('.content').find('.to:hidden').val(id.replace("id_", ""));
                $('.messages#' + id).parent('.content').find('.from:hidden').val(userSessionId);

                $(message).each(function (key, value) {
                    if (value.message.startsWith("<?= _l('chat_message_announce'); ?>")) {
                        value.message = '<strong class="italic">' + value.message + '</strong>';
                    }
                    if (value.is_deleted == 1) {
                        value.message = '<span>' + prchatSettings.messageIsDeleted + '</span>';
                    } else {
                        value.message = emojify.replace(value.message);
                    }
                    if (value.sender_id == userSessionId) {
                        $('.messages ul').prepend('<li class="sent" id="' + value.id + '"><img data-toggle="tooltip" data-container="body" data-placement="left" title="' + value.time_sent_formatted + '" class="myProfilePic" src="' + fetchUserAvatar(userSessionId, value.user_image) + '"/><p class="you" id="msg_' + value.id + '">' + value.message + '</p></li>');
                        <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
                        if (value.is_deleted == 0) {
                            $('#msg_' + value.id).tooltipster({
                                content: $("<span id='" + value.id + "' class='prchat_message_delete' ontouchstart='delete_chat_message(this)' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                                interactive: true,
                                side: 'left'
                            });
                        }
                        <?php endif; ?>

                    } else {
                        $('.messages ul').prepend('<li class="replies"><img data-toggle="tooltip" data-container="body" data-placement="right" title="' + value.time_sent_formatted + '" class="friendProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/><p  class="friend">' + value.message + '</p></li>');
                    }
                });
                $('.group_members_inline').remove();
            });
            fillSocialIconsData(obj);
            $('.messages').attr('id', id);

            activateLoader(promise);

            $.when(promise.then())
                .then(function () {
                    if ($(".messages").hasScrollBar() && $(window).width() > 733) {
                        scroll_event();
                        $('.message-input textarea.chatbox').focus();
                    } else if ($(window).width() < 733) {
                        // Due to mobile devices bug and loading time
                        scroll_event();
                        scroll_event();
                    } else {
                        // One last check for mobile devices
                        scroll_event();
                    }
                });

            $("#contacts").animate({
                scrollTop: "0px"
            });

            $('.contact #' + id + ' .from').val(presenceChannel.members.me.id);
            $('.contact #' + id + ' .to').val(obj.attr('href'));
            getSharedFiles(userSessionId, contact_id);
            $('#frame .nav.nav-tabs li.groups, #frame .nav.nav-tabs li.groups a, #frame .nav.nav-tabs li.crm_clients a').removeClass('events_disabled');
            $('.user_sound_icon').show();
            return false;
        }

        /*--------------------  * send message & typing event to server  * ------------------- */
        $("#frame").on('keypress', 'textarea.chatbox', function (e) {
            var form = $(this).parents('form');
            var imgPath = $('#sidepanel #profile .wrap img').prop('currentSrc');

            if (e.which == 13) {
                e.preventDefault();
                var message = $.trim($(this).val());
                if (message == '' || internetConnectionCheck() === false) {
                    return false;
                }

                message = createTextLinks_(emojify.replace(message));

                $('#contacts .contact.active').find('.wrap .meta .preview').html('<?php echo _l('chat_message_you'); ?>' + ' ' + escapeHtml(message));
                $('.messages ul').append('<li class="sent" id="' + userSessionId + '"><img class="myProfilePic" src="' + imgPath + '"/><p class="you" id="' + userSessionId + '">' + message + '</p></li>');
                $(this).next().next().next().val('false');
                message = escapeHtml(message);
                // send event
                var formData = form.serializeArray();

                $.post(prchatSettings.serverPath, formData);
                $(this).val('');
                $(this).focus();
                scroll_event();

            } else if (!$(this).val() || ($(this).next().next().next().val() == 'null' && $(this).val())) {
                // typing event
                $(this).next().next().next().val('true');
                $.post(prchatSettings.serverPath, form.serialize());
            }
        });

        /*---------------* Update user lastes message into dabatase *---------------*/
        function updateLatestMessages(id) {
            $.post(prchatSettings.updateUnread, {
                id: id
            }).done(function (r) {
                if (r != 'true') {
                    return false;
                }
                return true;
            });
        }

        /*---------------* Updating unread messages trigger and notification trigger *---------------*/
        function updateUnreadMessages(member_id) {
            var timeOut = 2000;
            member_id = $(member_id).attr('id');
            setTimeout(function () {
                if (member_id) {
                    updateLatestMessages(member_id);
                    $('.unread-notifications#' + member_id).hide();
                    return true;
                }
            }, timeOut)
        }

        /*---------------* Additional checks for chatbox and unread message update control *---------------*/
        $('#frame').on("click", "textarea.chatbox, div.messages", function () {

            var member_id = $('#sidepanel li.active a.active_chat').attr('id');

            if ($('.has_newmessages').attr('id') == member_id && $('.has_newmessages').val() == 'true') {
                updateLatestMessages(member_id);
                $('.has_newmessages').val('false');
            }
        });

        /*---------------* prevent showing dots if user is not typing *---------------*/
        $("#frame").on("focus", ".chatbox, .messages", function () {
            $('.messages').find('span.userIsTyping').fadeOut(500);
            if ($('.tb')) {
                $('.tb').css({
                    'font-weight': 'normal',
                    'color': 'rgba(153, 153, 153, 1)'
                });
            }
        });

        /*---------------* Switch user chat theme *---------------*/
        function chatSwitchTheme(theme_name) {
            $.post(prchatSettings.switchTheme, {
                theme_name: theme_name
            }).done(function (r) {
                if (r.success !== false) {
                    localStorage.chat_theme_name = theme_name;
                    location.reload();
                }
            });
        }

        /*---------------* Search members *---------------*/
        $("#frame #search #search_field").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#frame #contacts ul li").filter(function () {
                $(this).toggle($(this).children('a').find('p.name').text().toLowerCase().indexOf(value) > -1);
            });
        });

        /*---------------* On focus out clear out input field and show all members if not found in searchbox *---------------*/
        function clearSearchValues() {
            $('#frame #search_field').val('');
            $("#contacts ul li").filter(function () {
                $(this).css('display', 'block');
                $('#profile').click();
            });
        }

        $('#frame').keyup('#search_field', function (e) {
            if (e.keyCode === 27) {
                clearSearchValues();
            }
        });
        (jQuery);

        /*---------------* Fill Social Iconds with data *---------------*/
        function fillSocialIconsData(obj) {
            var social_info_attributes = $(obj).find('social_info');

            var socialMedia = [{
                type: 'skype',
                value: social_info_attributes[0].attributes.skype.value,
                link: 'skype:' + social_info_attributes[0].attributes.skype.value + '?call'
            },
                {
                    type: 'facebook',
                    value: social_info_attributes[0].attributes.facebook.value,
                    link: 'http://www.facebook.com/' + social_info_attributes[0].attributes.facebook.value
                },
                {
                    type: 'linkedin',
                    value: social_info_attributes[0].attributes.linkedin.value,
                    link: 'http://www.linkedin.com/in/' + social_info_attributes[0].attributes.linkedin.value
                },
            ];

            for (var i in socialMedia) {
                var element = $('#frame').find('.contact-profile #fa-' + socialMedia[i].type);
                socialMedia[i].value == '' ?
                    element.hide() :
                    element.attr('href', socialMedia[i].link).show()
            }
        }

        /*---------------* Delete own messages function *---------------*/
        function delete_chat_message(msg_id) {
            msg_id = $(msg_id).attr('id');
            var contact_id = $('#contacts ul li').children('a.active_chat').attr('id');
            var paragraph = "<p class='you message_was_deleted' id='" + msg_id + "'><span></span></p>";
            var selector = $(".messages li#" + msg_id);

            $.post(prchatSettings.deleteMessage, {
                id: msg_id,
                contact_id: contact_id
            }).done(function (response) {
                if (response == 'true') {
                    $('.tooltipster-base').hide();
                    selector.find("p#msg_" + msg_id).remove();
                    selector.append(paragraph);
                    selector.find("p.you.message_was_deleted#" + msg_id + ' span').html(prchatSettings.messageIsDeleted).removeClass('tooltipstered');
                    getSharedFiles(userSessionId, contact_id);
                } else {
                    alert_float('danger', '<?php echo _l('chat_error_float'); ?>');
                }
            });
        }

        /*---------------* Check contact/staff role and append *---------------*/
        function checkContactRole(contactRole) {
            if (contactRole == '1') {
                $('#frame .content .contact-profile p small').html("<?= _l('chat_role_administrator'); ?>")
            } else {
                $('#frame .content .contact-profile p small').html("<?= _l('chat_role_employee'); ?>")
            }
        }

        /*---------------* Init current chat loader synchronized with messages append *---------------*/
        function activateLoader(promise = null, client = false) {
            if (promise !== null) {
                var initLoader = (client) ? $('#frame .client_messages') : $('#frame .messages');
                if (initLoader.is(':visible')) {
                    if (initLoader.find('.message_loader').show()) {
                        promise.then(function () {
                            initLoader.find('.message_loader').hide();
                        });
                    }
                    ;
                }
            }
        }

        /*---------------* Get current chat shared files *---------------*/
        function getSharedFiles(own_id, contact_id) {
            $.post(prchatSettings.getSharedFiles, {
                own_id: own_id,
                contact_id: contact_id
            }).done(function (data) {
                $('.history_slider').html('');
                $('.history_slider').html(JSON.parse(data));
            })
        }


        /*---------------* Truncate text message to contacts view left side *---------------*/
        String.prototype.trunc = String.prototype.trunc ||
            function (n) {
                return (this.length > n) ? this.substr(0, n - 1) + '&hellip;' : this;
            };

        /*---------------* Scroll bottom *---------------*/
        function scroll_event() {
            var m = $('.messages'),
                gm = $('.group_messages'),
                cm = $('.client_messages');
            if (m.is(':visible') && m.hasScrollBar()) m.scrollTop(m[0].scrollHeight);
            if (gm.is(':visible') && gm.hasScrollBar()) gm.scrollTop(gm[0].scrollHeight);
            if (cm.is(':visible') && cm.hasScrollBar()) cm.scrollTop(cm[0].scrollHeight);
        }

        /*---------------* For mobile devices vh ports adjust for better UX *---------------*/
        var vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty("--vh", vh + "px");

        window.addEventListener("resize", function () {
            var vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty("--vh", vh + "px");
        });

        /*---------------* Theme events  *---------------*/
        $('#bottom-bar').on('click', '#switchTheme', function () {
            $('.dropdown-content').toggle("slide");
        });

        /*---------------* Check if staff has permissions for settings  *---------------*/
        $('#settings').on('click', function () {
            <?php if (staff_can('view', 'settings')) : ?>
            window.location = "<?php echo admin_url('settings?group=prchat-settings'); ?>";
            <?php else : ?>
            alert_float('warning', "<?php echo _l('chat_settings_permission'); ?>");
            <?php endif; ?>
        });

        /*---------------* Shared files on lick icon hide div with shared items  *---------------*/
        $('#sharedFiles').on('click', 'i.fa-times-circle-o', function () {
            $('#sharedFiles').css('display', 'none');
        });

        /*---------------* On click event for shared files  *---------------*/
        $('#shared_user_files').on('click', function () {
            (!$('#sharedFiles').is(':visible')) ?
                $('#sharedFiles').css('display', 'block') : $('#sharedFiles').css('display', 'none');
        });

        /*---------------* Eventr click tracker for shared files   *---------------*/
        $(".messages, .group_messages, #contacts, textarea, #header, #menu").on('click', function () {
            ($('#sharedFiles').is(':visible')) ?
                $('#sharedFiles').fadeOut() : false;

            ($('.chat_group_options').hasClass('active')) ?
                $('.chat_group_options').removeClass('active') : false;

        });

        /*---------------* Modal create announcement handler  *---------------*/
        $('#frame .dropdown .i_announcement').on('click', function () {
            $('.modal_container').load(prchatSettings.chatAnnouncement, function (res) {
                $('#chat_custom_modal').modal({
                    show: true
                });
            });
        });

        /*---------------* Modal create group handler  *---------------*/
        $('#frame .dropdown .i_groups, #frame #sidepanel #add_group_btn').on('click', function () {
            $('.modal_container').load(prchatSettings.chatGroups, function (res) {
                if ($('.modal-backdrop.fade').hasClass('in')) {
                    $('.modal-backdrop.fade').remove();
                }
                if ($('#chat_groups_custom_modal').is(':hidden')) {
                    $('#chat_groups_custom_modal').modal({
                        show: true
                    });
                }
            });
        });


        /*---------------* Some cached variables for group chat  *---------------*/
        var chat_group_messages = $('#frame .content .group_messages .chat_group_messages');
        var chat_client_messages = $('#frame .content .client_messages .chat_client_messages');
        var chat_contact_profile_img = $('#frame .content .contact-profile img');
        var chat_social_media = $('#frame .content .social-media');
        var chat_content_messages = $('#frame .content .messages');

        var changeSearchField = function () {
            $('#search #search_clients_field').attr('id', 'search_field');
            $('#search #search_field').attr('placeholder', "<?= _l('chat_search_chat_members'); ?>");
        };

        /*---------------* Click event for staff users sidebar  *---------------*/
        $('#frame #sidepanel .staff').click(function () {
            // hide groups form
            $('#frame form[name=groupMessagesForm],#frame form[name=clientMessagesForm], #frame .groupOptions').hide();

            $('#frame .chat_group_options.active').hide().removeClass('active');
            $('#frame form[name=pusherMessagesForm]').show();
            $('.client_data').remove();

            if ($('.group_members_inline').remove()) {

                chat_contact_profile_img.show();
                chat_contact_profile_img.next().show();
                chat_contact_profile_img.next().next().show();
                chat_social_media.show();
                chat_content_messages.show();

            }


            if (!optionsSelector.hasClass('active')) {
                optionsSelector.css('display', '');
            }

            clientsListCheck();

            changeSearchField();

            $('.group_members_inline').remove();
            $('#frame #contacts ul li').first().children('a').first().click();

        });


        /*---------------* Click event for groups sidebar  *---------------*/
        $('#frame #sidepanel .groups').click(function () {

            // Hide staff chatbox form
            $('#frame form[name=pusherMessagesForm], #frame form[name=clientMessagesForm], #sharedFiles').hide();
            $(this).removeClass('flashit');
            $('.client_data').remove();

            chat_group_messages.html('');
            chat_group_messages.append('<ul></ul>');

            // show groups form
            $('#frame .content .group_messages, #frame form[name=groupMessagesForm]').show();

            chat_content_messages.hide();
            chat_contact_profile_img.hide();
            chat_contact_profile_img.next().hide();
            chat_contact_profile_img.next().next().hide();

            $('#frame ul.chat_groups_list li.active a').click();

            var group_id = $('#frame ul.chat_groups_list li.active').attr('id');

            getGroupMessages(group_id);

            appendOptionsBar();

            clientsListCheck();

            changeSearchField();

            if (group_id == undefined) {
                $('.message_group_loader').hide();
            }
        });
    </script>
<?php require('modules/prchat/assets/module_includes/groups.php'); ?>
<?php
if (isClientsEnabled()) {
    require('modules/prchat/assets/module_includes/crm_clients.php');
}
?>
<?php require('modules/prchat/assets/module_includes/chat_sound_settings.php'); ?>