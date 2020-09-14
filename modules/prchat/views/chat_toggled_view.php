<?php

defined('BASEPATH') or exit('No direct script access allowed');

$color    = pr_get_chat_color(get_staff_user_id(), 'chat_color');
$currentChatColor = validateChatColorBeforeApply($color);

?>
<div id="pusherChat">
  <div id="mainChatId" class="draggable" style="display:none;">
    <div id="membersContent">
      <div class="chatMain">
        <div class="topInfo" onclick="slideChat(this)" style="background:<?php echo $currentChatColor; ?>;">
          <p class="cname">
            <?php echo get_option('companyname'); ?>
          </p>
          <i class="fa fa-th-large main_chat" data-toggle="tooltip" data-original-title="<?php echo _l('chat_browser_full_chat') ?>" data-placement="left"></i>
        </div>
      </div>
      <div class="connection_field">
        <i class="fa fa-wifi blink"></i>
      </div>
      <div class="scroll">
        <div id="members-list"></div>
        <input class="form-control searchBox search_hidden" placeholder="<?php echo _l('chat_search_chat_members'); ?>" />
      </div>
      <div class="chat-footer" style="background:<?php echo $currentChatColor; ?>">
        <div class="online" onclick="slideChat(this)">
          <?php echo _l('chat_online_users'); ?>
          <i onclick="chatCircleTransform();" data-toggle="tooltip" title="<?= _l('chat_toggle_circle_text'); ?>" class="fa fa-comments"></i>
          <span id="count">0</span>
        </div>
        <i class="fa fa-volume-up" data-toggle="tooltip" data-placement="left" title="<?= _l('chat_sound_notifications'); ?>" aria-hidden="true" id="disableSound"></i>
        <i class="fa fa-search" data-toggle="tooltip" title="<?= _l('chat_search_chat_members'); ?>" id="searchUsers" aria-hidden="true"></i>
        <div class="dropup">
          <button class="btn btn-primary dropdown-toggle gradientButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog" id="colorGradientChanger" aria-hidden="true" data-toggle="tooltip" data-original-title="<?= _l('chat_color_settings'); ?>"></i>
          </button>
          <ul class="dropdown-menu" id="colorChangerMenu">
            <li><a href="#" id="colorChanger"><i class="fa fa-paint-brush" aria-hidden="true"></i><?= _l('chat_solid_color_text'); ?></a></li>
            <li><a href="#" id="colorGradient"><i class="fa fa-paint-brush" aria-hidden="true"></i><?= _l('chat_gradient_color_text'); ?></a></li>
            <li><a href="#" id="resetColors" onClick="resetChatColors()"><i class="fa fa-refresh" aria-hidden="true"></i><?= _l('chat_reset_color_text'); ?></a></li>
          </ul>
        </div>
        <div class="form-inline colorHolder">
          <form method="POST" name="solidForm" style="display: none" action="<?php echo site_url('prchat/Prchat_Controller/colorchange/'); ?>" onsubmit="changeColor(this); return false;">
            <input type="text" name="color" class="form-control jscolor float-right chat_color" value="<?php echo $currentChatColor; ?>" required />
            <button class="btn btn-success btn-sm" id="chColor" type="submit">
              <?php echo _l('chat_change_color'); ?>
            </button>
            <button type="button" class="btn btn-secondary  closeColorButton">Close</button>
          </form>
          <form method="POST" name="gradientForm" style="display: none" action="<?php echo site_url('prchat/Prchat_Controller/colorchange/'); ?>" onsubmit="changeColor(this); return false;">
            <input type="text" name="color" class="form-control float-right chat_color" value="" required placeholder="<?php echo _l('chat_color_example_type'); ?>" />
            <button class="btn btn-success btn-sm" id="chGradientColor" type="submit">
              <?php echo _l('chat_change_color'); ?>
            </button>
            <button type="button" class="btn btn-secondary closeColorButton">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Positions of chat and main chat append on browser when load
    var positions = JSON.parse(localStorage.positions || "{}");
    $.each(positions, function(id, pos) {
      $("#pusherChat #" + id).css(pos);
    });
    setTimeout(function() {
      $('#mainChatId').css('display', 'block');
    }, 200);
  </script>
  <!-- Chat Box Template -->
  <div id="templateChatBox">
    <div class="pusherChatBox">
      <span class="state">
        <span class="userIsTyping"><img src="<?php echo module_dir_url('prchat', 'assets/chat_implements/userIsTyping.gif'); ?>" /></span>
        <span class="quote">
          <div class="notification-box">
            <span class="notification-count">0</span>
            <div class="notification-bell">
              <span class="bell-top"></span>
              <span class="bell-middle"></span>
              <span class="bell-bottom"></span>
              <span class="bell-rad"></span>
            </div>
          </div>
        </span>
      </span>
      <span class="user_view_selector">
        <i class="fa fa-th-large user_view" data-toggle="tooltip" data-original-title="<?php echo _l('chat_browser_full_chat') ?>" data-placement="left"></i>
      </span>
      <span class="closeBox">
        <i class="fa fa-close" data-toggle="tooltip" title="<?= _l('close'); ?>"></i>
      </span>
      <chatHead class="chat-head" style="background:<?php echo $currentChatColor; ?>" onclick="slideChat(this)">
        <span class="userName"></span>
      </chatHead>
      <div class="slider">
        <div class="logMsg">
          <svg class="message_loader" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
          </svg>
          <div class="msgTxt">
          </div>
        </div>
        <div class="fileUpload" data-toggle="tooltip" title="<?php echo _l('chat_file_upload'); ?>">
          <i class="fa fa-plus-circle" aria-hidden="true"></i>
        </div>
        <form hidden enctype="multipart/form-data" name="fileForm" method="post" onsubmit="uploadFileForm(this);return false;">
          <input type="file" class="file" name="userfile" required />
          <input type="submit" name="submit" class="save" value="save" />
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>
        <form method="post" enctype="multipart/form-data" name="pusherMessagesForm" onsubmit="return false;">
          <div>
            <div class="enterBtn">
              <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </div>
            <textarea name="msg" class="chatbox" rows="3" placeholder="<?php echo _l('chat_type_a_message'); ?>"></textarea>
            <input type="hidden" name="from" class="from" />
            <input type="hidden" name="to" class="to" />
            <input type="hidden" name="typing" class="typing" value="false" />
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Chat Box Template End -->
<div class="chatBoxWrap">
  <div class="chatBoxslide"></div>
  <span id="slideLeft"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
  <span id="slideRight"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
</div>
</div>
<?php require_once('modules/prchat/assets/module_includes/chat_settings.php'); ?>
<!-- Chat Template End -->

<script>
  $(function() {
    'use strict';

    if (localStorage.isToggled == 'true') {
      $('#membersContent').hide(function() {
        setTimeout(function() {
          $('#membersContent').show();
        }, 2000);
      });
    }
  });

  var wentOffline, wentOnline;
  window.addEventListener('online', handleConnectionChange);
  window.addEventListener('offline', handleConnectionChange);
  // Parse emojies in chat area do not touch
  emojify.setConfig({
    emojify_tag_type: 'div',
    'img_dir': site_url + '/modules/prchat/assets/chat_implements/emojis'
  });
  emojify.run();

  var getCurrentBackgound = '';
  var prevBackground = "<?php echo $currentChatColor; ?>";
  var pageTitle = $('title').html();
  var pusherKey = "<?php echo get_option('pusher_app_key') ?>";
  var appCluster = "<?php echo get_option('pusher_cluster') ?>";
  var staffFullName = "<?php echo get_staff_full_name(); ?>";
  var userSessionId = "<?php echo get_staff_user_id(); ?>";

  $('#pusherChat').on('click', '.fileUpload', function() {
    $(this).parents('.pusherChatBox').find('form input:first').trigger('click');
  });

  $('#pusherChat').on('change', 'input[type=file]', function() {
    var id = $(this).attr('name');
    $('form#' + id).submit();
  });

  function uploadFileForm(file) {
    var formData = new FormData();
    var fileForm = $(file).children('input[type=file]')[0].files[0];
    var sentTo = $(file).attr('id');
    var token_name = $(file).children('input:nth-child(3)').val();
    var formId = $(file).attr('id');

    formData.append('userfile', fileForm);
    formData.append('send_to', sentTo);
    formData.append('send_from', userSessionId);
    formData.append('csrf_token_name', token_name);

    $.ajax({
      type: 'POST',
      url: '<?php echo site_url('prchat/Prchat_Controller/uploadMethod'); ?>',
      data: formData,
      dataType: 'json',
      processData: false,
      contentType: false,
      beforeSend: function() {
        $('.pusherChatBox#' + sentTo).prepend('<div class="chat-module-loader"><div></div><div></div><div></div></div>');

        var Regex = new RegExp('\[~%:\()@]');
        if (Regex.test(fileForm.name)) {
          alert_float('warning', '<?php echo _l('chat_permitted_files') ?>');
          $('.pusherChatBox#' + sentTo + ' .chat-module-loader').remove();
          return false;
        }
      },
      success: function(r) {

        if (r.error) {
          alert_float('danger', r.error);
          $('.pusherChatBox#' + sentTo + ' .chat-module-loader').fadeOut();
          return;
        }

        const uploadSend = $.Event("keypress", {
          which: 13
        });
        var basePath = "<?php echo module_dir_url('prchat', 'uploads/'); ?>";

        $('#pusherChat .pusherChatBox#' + formId + ' textarea').val(basePath + r.upload_data.file_name);
        setTimeout(function() {

          if ($('#pusherChat .pusherChatBox#' + formId + ' textarea').trigger(uploadSend)) {
            alert_float('info', 'File ' + r.upload_data.file_name + ' sent.');
            $('.pusherChatBox#' + sentTo + ' .chat-module-loader').fadeOut();
          }

        }, 100);

        var messagesContainer = $('#pusherChat .pusherChatBox#' + formId + ' .logMsg');
        messagesContainer.animate({
          scrollTop: messagesContainer.prop("scrollHeight")
        }, 1000);

      }
    });
    $('form#' + formId).trigger("reset");
  }

  function loadMessages(el) {
    var pos = $(el).scrollTop();
    var id = $(el).attr("id");
    var to = $(el).parents().find('.pusherChatBox#' + id).attr('id').replace("id_", "");
    var from = userSessionId;

    if (endOfScroll[to] == true) {
      prchat_setNoMoreMessages(to);
      return false;
    }

    if (pos == 0) {

      activateLoader(id, true);
      initiatePrepending = function() {
        $.get(prchatSettings.getMessages, {
          from: from,
          to: to,
          offset: offsetPush[to]
        }).done(function(message) {

          message = JSON.parse(message);

          if (Array.isArray(message) == false) {
            endOfScroll[to] = true;
            prchat_setNoMoreMessages(to);
          } else {
            offsetPush[to] += 10;
          }

          $(message).each(function(key, value) {
            if (value.is_deleted == 1) {
              value.message = prchatSettings.messageIsDeleted;
            } else {
              value.message = emojify.replace(value.message);
            }
            var element = $('.pusherChatBox#id_' + to + ' .logMsg .msgTxt');
            if (value.reciever_id == from) {
              element.prepend('<em><div class="conversation_from"><img class="friendProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/></br><p data-toggle="tooltip" title="' + value.time_sent_formatted + '" class="friend">' + value.message + '</p></div></em>');
            } else {
              element.prepend('<em><div class="conversation_me"><img class="myProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/></br><div class="message_container"><p data-toggle="tooltip" title="' + value.time_sent_formatted + '" class="you" id="' + value.id + '" style="background:' + prchatSettings.getChatColor + '">' + value.message + '</p></div></div></em>');
              <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
                if (value.is_deleted == 0) {
                  $('.conversation_me #' + value.id).tooltipster({
                    content: $("<span id='" + value.id + "' class='prchat_message_delete' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                    interactive: true,
                    side: 'left'
                  });
                }
              <?php endif; ?>
            }
          });
          if (endOfScroll[to] == false) {
            $(el).scrollTop(200);
          }
        });
      };
    }
  }

  $('#pusherChat').on('click', '#disableSound', function() {
    if (isSoundMuted == '') {
      isSoundMuted = 'muted';
      $(this).toggleClass("fa fa-volume-up fa fa-volume-off");
    } else if (isSoundMuted == 'muted') {
      $(this).toggleClass("fa fa-volume-off fa fa-volume-up");
      isSoundMuted = '';
    }
  });

  $('#pusherChat').on('click', '.enterBtn', function() {
    const eventEnter = $.Event("keypress", {
      which: 13
    });
    $(this).parents('.pusherChatBox').find('textarea').trigger(eventEnter);
  });

  if (prchatSettings.debug) {
    try {
      Pusher.log = function(message) {
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

  var pusher = new Pusher(pusherKey, {
    authEndpoint: "<?php echo site_url('prchat/Prchat_Controller/pusher_auth'); ?>",
    authTransport: 'jsonp',
    'cluster': appCluster,
  });

  /*---------------* Pusher Trigger accessing channel *---------------*/
  var presenceChannel = pusher.subscribe('presence-mychanel');

  /*---------------* Pusher Trigger subscription succeeded *---------------*/
  presenceChannel.bind('pusher:subscription_succeeded', function(members) {
    chatMemberUpdate(true);
  });

  /*---------------* Pusher Trigger user connected *---------------*/
  presenceChannel.bind('pusher:member_added', function(members) {
    chatMemberUpdate();
    addChatMember(members);
    if (members.info.justLoggedIn) {
      $('.liveUsers').remove();
      $("#menu .menu-item-prchat span").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (presenceChannel.members.count - 1) + '</span>');
      $.notify('', {
        'title': app.lang.new_notification,
        'body': members.info.name + ' ' + prchatSettings.hasComeOnlineText,
        'requireInteraction': true,
        'icon': $('#header').find('img').attr('src'),
        'tag': 'user-join-' + members.id,
        'closeTime': 5000,
      })
    }
  });

  /*---------------* Pusher Trigger user logout *---------------*/
  presenceChannel.bind('pusher:member_removed', function(members) {
    removeChatMember(members);
  });

  /*---------------* Bind the 'send-event' & update the chat box message log *---------------*/
  presenceChannel.bind('send-event', function(data) {
    if (data.global) {
      data.message = "<?= '<strong>' . _l('chat_message_announce') . '</strong>'; ?>" + data.message;
    }
    var current_time = new Date().toLocaleTimeString();
    var obj = $("a[href=\\#" + data.from + "]");
    if (presenceChannel.members.me.id == data.to && data.from != presenceChannel.members.me.id) {
      playPushSound();
      if ($('.pusherChatBox.on#id_' + data.from).hasClass('stillActive')) {
        $('.pusherChatBox#id_' + data.from).css('display', 'block');
        updateBoxPosition(obj);
      }
      data.message = createTextLinks_(emojify.replace(data.message));
      var pusherFrom = $('#pusherChat .pusherChatBox#id_' + data.from);
      var pusherDataLogMsg = $('#pusherChat .pusherChatBox#id_' + data.from + ' .logMsg');
      var name = $('.pusherChatBox#id_' + data.from).find('.userName').html();
      if (pusherFrom.hasClass('hanging')) {
        pusherFrom.find('.chat-head').click();
      }
      $('#pusherChat .pusherChatBox#id_' + data.from + ' .state').show();
      pusherFrom.addClass('stillActive');
      pusherFrom.addClass('receiveMsg').removeClass('writing');
      pusherDataLogMsg.find('.msgTxt').show();
      $('#pusherChat .pusherChatBox#id_' + data.from + ' .msgTxt').append('<div class="conversation_from"><img class="friendProfilePic" data-toggle="tooltip" title="' + current_time + '" src="' + fetchUserAvatar(data.from, data.sender_image) + '"/></br><p class="friend">' + data.message + '</p></div>');
      $('title').html('');
      if ($('title').text().search('<?php echo _l('chat_sent_you_a_message'); ?>') == -1) {
        if (name !== undefined) {
          $('title').text(name + ' <?php echo _l('chat_sent_you_a_message'); ?>');
        } else {
          $('title').text('<?php echo _l('chat_you_have_a_new_message'); ?>');
        }
        if ($('.pusherChatBox#id_' + data.from).is(':hidden')) {
          playPushSound();
        }
      }
      createChatBox(obj);
      $('#pusherChat .pusherChatBox#id_' + data.from + ' .logMsg').scrollTop($('#pusherChat .pusherChatBox#id_' + data.from + ' .logMsg')[0].scrollHeight);
    }
    if (presenceChannel.members.me.id == data.from) {

      data.message = createTextLinks_(emojify.replace(data.message));
      $('#pusherChat .pusherChatBox#id_' + data.to + ' .msgTxt').append('<div class="conversation_me"><img class="myProfilePic" data-toggle="tooltip" title="' + current_time + '" src="' + fetchUserAvatar(userSessionId, data.sender_image) + '"/></br><div class="message_container"><p class="you" style="background:' + getCurrentBackgound + '" id="' + data.last_insert_id + '">' + data.message + '</p></div></div>');
      var pusherDatalogMsgTo = $('#pusherChat .pusherChatBox#id_' + data.to + ' .logMsg');
      pusherDatalogMsgTo.scrollTop(pusherDatalogMsgTo[0].scrollHeight);
      <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
        $('.message_container #' + data.last_insert_id).tooltipster({
          content: $("<span id='" + data.last_insert_id + "' class='prchat_message_delete' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
          interactive: true,
          side: 'left'
        });
      <?php endif; ?>
    }
  });


  /*---------------* Detect when a user is typing a message *---------------*/
  presenceChannel.bind('typing-event', function(data) {
    if (presenceChannel.members.me.id == data.to && data.from !== presenceChannel.members.me.id && data.message == 'true') {
      $('#id_' + data.from).find('span.userIsTyping img').show();
      $('#id_' + data.from).addClass('writing');
    } else if (presenceChannel.members.me.id == data.to && data.from != presenceChannel.members.me.id && data.message == 'null') {
      $('#id_' + data.to).find('span.userIsTyping img').fadeOut();
      $('#id_' + data.to).removeClass('writing');
    }
  });

  /*---------------* Trigger notification popup increment*---------------*/
  presenceChannel.bind('notify-event', function(data) {
    var chatBox = $('.pusherChatBox.on#id_' + data.from).find('.chatbox');
    var notiBox = $('.pusherChatBox.on#id_' + data.from).find('.notification-box');
    var notiCount = $('.pusherChatBox.on#id_' + data.from).find('.notification-count');
    if (!chatBox.is(':focus')) {
      var notiValue = parseInt(notiCount.html());
      if (notiBox.is(':hidden')) {
        $(notiBox.show());
      }
      $(notiCount.html(notiValue = notiValue + 1));
    } else {
      $(notiBox).hide();
    }
  });

  /*---------------* Trigger when user stop typing *---------------*/
  $("#pusherChat").on("focusout", ".chatbox", function() {
    var from = $(this).parents('form');
    if ($(this).next().next().next().val() == 'true') {
      $.post(prchatSettings.serverPath, from.serialize());
      $(this).next().next().next().val('null');
    }
  });

  /*---------------* Slide up & down users list & chat boxes, update messages *---------------*/
  $('#pusherChat').on("click", ".pusherChatBox chathead", function(event) {
    var obj = $(this);
    var id = obj.parent().attr('id');
    var selector = $('#pusherChat .pusherChatBox#' + id + ' .slider');
    if ($(obj).hasClass('hanging')) {
      $(selector).find('.fileUpload').animate({
        height: ["toggle", "swing"],
        opacity: "toggle"
      });
      $(selector).find('.enterBtn').animate({
        height: ["toggle", "swing"],
        opacity: "toggle"
      });
    }
    $('#pusherChat .pusherChatBox#' + id + ' .logMsg').scrollTop($('#pusherChat .pusherChatBox#' + id + ' .logMsg')[0].scrollHeight);
  });

  /*---------------* Close chatbox, update messages *---------------*/
  $('#pusherChat').on("click", ".closeBox", function(event) {
    soundFinished = false;
    var id = $(this).parents('.pusherChatBox').attr('id');
    var updateId = $(this).parents('.pusherChatBox').attr('id').replace("id_", "");
    removeActiveChatWindow(updateId);
    var chatBox = $(this).parents('.pusherChatBox#' + id);
    var selector = $('#pusherChat .pusherChatBox#' + id + ' .slider');
    $(selector).find('.fileUpload').css("display", "block");
    $(selector).find('.enterBtn').css("display", "block");
    $(this).parents('.pusherChatBox#' + id).hide();
    $(this).parents('.pusherChatBox.on#' + id).addClass('stillActive');
    $(chatBox).find('.slider').addClass('animated fadeIn').show();
    $(chatBox).find('.notification-count').text('0');
    updateBoxPosition();
    return false;
  });

  /*---------------* Trigger click on user & create chat box and check for messages *---------------*/
  $('#pusherChat #members-list').on("click", "a", function(event) {
    $('#pusherChat .scroll').animate({
      scrollTop: 0
    });
    var obj = $(this);
    var id = obj.attr('id');

    addActiveChatWindow({
      id: id,
      fullName: obj.find('.user-name').text().trim()
    });

    var hasActiveWindowClickClass = $(this).hasClass('active-windows-click');
    createChatBox(obj);

    var chatBox = obj.parents('#pusherChat').find('.pusherChatBox#id_' + id);
    var notiBox = $(this).children('.unread-notifications').data('badge');

    if (!hasActiveWindowClickClass && notiBox > 0) {
      updateUnreadMessages(this, chatBox);
    }

    if ($(chatBox).is(':visible') && !$(chatBox).hasClass('manually-added')) {
      $(chatBox).find('.slider').addClass('animated fadeIn').show();
    }

    $(chatBox).removeClass('manually-added');

    if ($(chatBox).hasClass('on')) {
      $('#pusherChat .pusherChatBox#id_' + id + ' .logMsg').scrollTop($('#pusherChat .pusherChatBox#id_' + id + ' .logMsg')[0].scrollHeight);
    }
  });


  $('#slideLeft').on('click', function() {
    $('.chatBoxslide .pusherChatBox:visible:first').addClass('overFlowHide');
    $('.chatBoxslide .pusherChatBox.overFlow').removeClass('overFlow');
    updateBoxPosition();
  });

  $('#slideRight').on('click', function() {
    $('.chatBoxslide .pusherChatBox.overFlowHide:last').removeClass('overFlowHide');
    updateBoxPosition();
  });

  /*--------------------  * send message & typing event to server  * ------------------- */
  $("#pusherChat").on('keypress', '.pusherChatBox textarea', function(e) {
    var form = $(this).parents('form');
    var chatId = $(form).parents().parent('.pusherChatBox').attr('id');
    if (e.which == 13) {
      var message = $(this).val();
      if (message.trim() == '' || internetConnectionCheck() === false) {
        return false;
      }
      var msgTxt = $('.logMsg').find('.msgTxt');
      if (!$(msgTxt).is(':visible')) {
        $('.logMsg').find('.msgTxt').show();
      }
      $('#pusherChat #' + chatId + ' .logMsg').scrollTop($('#pusherChat #' + chatId + ' .logMsg')[0].scrollHeight); // just in case
      $(this).next().next().next().val('false');
      // Send event
      $.post(prchatSettings.serverPath, form.serialize());
      e.preventDefault();
      $(this).val('');
      $(this).focus();
    } else if (!$(this).val() || ($(this).next().next().next().val() == 'null' && $(this).val())) {
      // Typing event
      $(this).next().next().next().val('true');
      $.post(prchatSettings.serverPath, form.serialize());
    }
  });

  /*-----------------------    * additional dynamic styling  *-----------------------*/
  $('#pusherChat .chatBoxWrap').css({
    'width': $(window).width() - $('#membersContent').width() - 30
  });

  $(window).resize(function() {
    $('#pusherChat .chatBoxWrap').css({
      'width': $(window).width() - $('#membersContent').width() - 30
    });
    updateBoxPosition();
  });

  /*---------------* Additional checks for chatbox and unread message update control *---------------*/
  $('#pusherChat').on("click", ".logMsg, textarea", function(e) {
    var member_id = $(this).prev('div.enterBtn').attr('id') || $(this).attr('id');
    var pusherChatBox = $(this).parents('.pusherChatBox#' + member_id);
    var toUpdate = pusherChatBox.children('.state').children('.quote').find('.notification-box .notification-count').text();
    if (toUpdate > 0) {
      updateUnreadMessages(this, pusherChatBox);
    }
  });

  /*---------------* prevent showing dots if user is not typing *---------------*/
  $("#pusherChat").on("focus", ".chatbox", function() {
    $('.pusherChatBox.on.writing').find('span.userIsTyping img').fadeOut().removeClass('writing receiveMsg');
  });

  /*---------------* Search users *---------------*/
  $(".searchBox").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#members-list a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  /*---------------* On click show input search field and focus *---------------*/
  $('#searchUsers').click(function() {
    if ($('.searchBox').hasClass('search_hidden')) {
      if ($('.scroll').is(':hidden')) {
        $('.scroll').show();
      }
      localStorage.chat_head_position = 'block';
      $('.searchBox').css('display', 'block');
      $('.searchBox').focus();
    }
  });

  /*---------------* On focus out clear out input field and show all users if not found in searchbox *---------------*/
  $('#membersContent').keyup('.searchBox', function(e) {
    if (e.keyCode === 27) {
      clearSearchValues();
    }
  });
  $('#membersContent').focusout('.searchBox', function() {
    clearSearchValues();
  });

  /*---------------* Change Boxes, Chat color update in database and dynamically set color *---------------*/
  var solidColorForm = $('#membersContent').find('form[name=solidForm]');
  var gradientColorForm = $('#membersContent').find('form[name=gradientForm]');

  $(document).on('click', '#colorChanger', function() {
    gradientColorForm.hide();
    solidColorForm.show();
    return false;
  });

  $('body').on('click', '.closeColorButton', function() {
    $(this).parent('form').toggle();
  })

  $(document).on('click', '#colorGradient', function() {
    gradientColorForm.show();
    solidColorForm.hide();
    return false;
  });

  /*---------------* Responsible for loading message history and UI experience *---------------*/
  function slideChat(chatHead) {
    if ($(chatHead).hasClass('topInfo') || $(chatHead).hasClass('online')) {

      if (!$('#mainChatId').hasClass('main-chat-dragging')) {
        $(chatHead).parents('#membersContent').find('.scroll').slideToggle('fast');

        var scroll = $('#membersContent .scroll');
        if (localStorage.chat_head_position == 'none') {
          localStorage.chat_head_position = 'block';
        } else {
          localStorage.chat_head_position = 'none';
        }
      } else {
        $('#mainChatId').removeClass('main-chat-dragging');
      }

    } else {
      if (prevBackground != getCurrentBackgound) {
        $(chatHead).parents('.pusherChatBox').find('p.you').attr('style', 'background: ' + getCurrentBackgound + ' !important');
      }
      $(chatHead).next().slideToggle('fast');
      var box = $(chatHead).parents('.pusherChatBox');
      if (box.hasClass('hanging')) {
        var id = box.attr('id').replace('id_', '');
        $('#members-list').find('a#' + id).click();
      }
    }
  }

  /*---------------* Creating chat box from the html template to the DOM *---------------*/
  function createChatBox(obj) {
    var id = obj.attr('href');
    var message = '';
    var fullName = obj.children('span').text();
    var getMsgId = id.replace("#", "");
    id = id.replace("#", "id_");
    var off = 'on';

    if (obj.hasClass('off')) {
      off = 'off';
    }

    var fromActiveChatWindowsClick = obj.hasClass('active-windows-click');
    var onlyLoadMessages = $('.pusherChatBox#' + id).hasClass('hanging');

    var dfd = $.Deferred();
    var promise = dfd.promise();

    if (!$('.pusherChatBox#' + id).html() || onlyLoadMessages) {

      $('.pusherChatBox#' + id).removeClass('hanging')

      if (!fromActiveChatWindowsClick) {
        $.get(prchatSettings.getMessages, {
            from: userSessionId,
            to: getMsgId,
            offset: 0
          })
          .done(function(r) {
            r = JSON.parse(r);
            message = r;

            if (typeof(offsetPush[getMsgId]) == 'undefined') {
              offsetPush[getMsgId] = 0;
            }

            if (typeof(endOfScroll[getMsgId]) == 'undefined') {
              endOfScroll[getMsgId] = 0;
            }

            offsetPush[getMsgId] += 10;
            dfd.resolve(message);
          });
      } else {
        dfd.resolve([]);
      }

      $('#templateChatBox .pusherChatBox chatHead .userName').html(fullName);

      promise.then(function(message) {
        $('.pusherChatBox#' + id + ' .logMsg .msgTxt').css('display', 'block');
        if (!$('.pusherChatBox#' + id + ' form:hidden').attr('id')) {
          $('.pusherChatBox#' + id + ' form:hidden').attr('id', id);
          $('.pusherChatBox#' + id + ' form:hidden input:first').attr('name', id);
          $('.pusherChatBox#' + id + ' .enterBtn').attr('id', id);
        }
        if (obj.hasClass('on')) {
          $(message).each(function(key, value) {
            if (value.message.startsWith("<?= _l('chat_message_announce'); ?>")) {
              value.message = '<strong class="italic_small">' + value.message + '</strong>';
            }
            if (value.is_deleted == 1) {
              value.message = prchatSettings.messageIsDeleted;
            } else {
              value.message = emojify.replace(value.message);
            }
            if (value.reciever_id == userSessionId) {
              $('.pusherChatBox#' + id + ' .logMsg .msgTxt').prepend('<div class="conversation_from"><img class="friendProfilePic" data-toggle="tooltip" title="' + value.time_sent_formatted + '" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/></br><p class="friend">' + value.message + '</p></div>');
            } else {
              $('.pusherChatBox#' + id + ' .logMsg .msgTxt').prepend('<div class="conversation_me"><img class="myProfilePic" data-toggle="tooltip" title="' + value.time_sent_formatted + '" src="' + fetchUserAvatar(userSessionId, value.user_image) + '"/></br><div class="message_container"><p data-toggle="tooltip"  id="' + value.id + '" title="' + value.time_sent_formatted + '" class="you">' + value.message + '</p></div></div>');
              <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
                if (value.is_deleted == 0) {
                  $('.conversation_me #' + value.id).tooltipster({
                    content: $("<span id='" + value.id + "' class='prchat_message_delete' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                    interactive: true,
                    side: 'left'
                  });
                }
              <?php endif; ?>
            }
          });
          $('#pusherChat #' + id + ' .logMsg').scrollTop($('#pusherChat #' + id + ' .logMsg')[0].scrollHeight);
        } else if (obj.hasClass('off')) {
          $(message).each(function(key, value) {
            if (value.is_deleted == 1) {
              value.message = prchatSettings.messageIsDeleted;
            } else {
              value.message = emojify.replace(value.message);
            }
            if (value.reciever_id == userSessionId) {
              $('.pusherChatBox#' + id + ' .logMsg .msgTxt').prepend('<div class="conversation_from"><img class="friendProfilePic" data-toggle="tooltip" title="' + value.time_sent_formatted + '" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/></br><p class="friend">' + value.message + '</p></div>');
            } else {
              $('.pusherChatBox#' + id + ' .logMsg .msgTxt').prepend('<div class="conversation_me"><img class="myProfilePic" data-toggle="tooltip" title="' + value.time_sent_formatted + '" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/></br><div class="message_container"><p id="' + value.id + '" class="you">' + value.message + '</p></div></div>');
              <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
                if (value.is_deleted == 0) {
                  $('.conversation_me #' + value.id).tooltipster({
                    content: $("<span id='" + value.id + "' class='prchat_message_delete' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                    interactive: true,
                    side: 'left'
                  });
                }
              <?php endif; ?>
            }
          });
        }
        $('#pusherChat #' + id + ' .logMsg').scrollTop($('#pusherChat #' + id + ' .logMsg')[0].scrollHeight);

      });

      if (!onlyLoadMessages) {
        var $cloned = $('#templateChatBox .pusherChatBox').clone().attr('id', id);
        if (fromActiveChatWindowsClick) {
          $cloned.find('.slider').css('display', 'none');
          $cloned.addClass('manually-added');
          $cloned.addClass('hanging');
          obj.removeClass('active-windows-click');
        }
        $('.chatBoxslide').prepend($cloned);
      }

      $('.pusherChatBox#' + id + ' .logMsg').attr('id', id);
      $('.pusherChatBox#' + id + ' .logMsg').attr('onscroll', 'loadMessages(this)');

      setTimeout(function() {
        // UI Experience
        activateLoader(id, false);
      }, 800);

      setTimeout(function() {
        $('[data-toggle="tooltip"]').tooltip();
        if (prevBackground != getCurrentBackgound) {
          $('.pusherChatBox#' + id + ' .msgTxt p.you').filter(function() {
            $(this).css('background', '' + getCurrentBackgound + '');
          });
        }
        $('#pusherChat #' + id + ' .logMsg').scrollTop($('#pusherChat #' + id + ' .logMsg')[0].scrollHeight);
        $('.pusherChatBox#' + id + ' textarea').focus();
      }, 300);
    } else if (!$('.pusherChatBox#' + id).is(':visible')) {
      setTimeout(function() {
        $('.pusherChatBox#' + id + ' textarea').focus();
        $('.pusherChatBox#' + id + ' .logMsg').scrollTop($('.pusherChatBox#' + id + ' .logMsg')[0].scrollHeight);
      }, 300);
      clone = $('.pusherChatBox#' + id).clone();
      $('.pusherChatBox#' + id).remove();

      if (!$('.chatBoxslide .pusherChatBox:visible:first').html()) {
        $('.chatBoxslide').prepend(clone.show());
      } else {
        $(clone.show()).insertBefore('.chatBoxslide .pusherChatBox:visible:first');
      }
    }
    $('.pusherChatBox#' + id + ' textarea').focus();
    $('.pusherChatBox#' + id + ' .from').val(presenceChannel.members.me.id);
    $('.pusherChatBox#' + id + ' .to').val(obj.attr('href'));
    $('.pusherChatBox#' + id).addClass(off);
    updateBoxPosition();

    return false;

  }
  $(document).keyup(function(e) {
    if (e.keyCode == 27) {
      var $prChatChatboxes = $("body").find('.closeBox');
      $.each($prChatChatboxes, function() {
        if ($(this).parents('.pusherChatBox').find('.chatbox').is(':focus')) {
          $(this).trigger('click');
        }
      });
    }
  });

  /*---------------* Delete own messages function *---------------*/
  function delete_chat_message(msg_id) {
    msg_id = $(msg_id).attr('id');
    var selector = $("p#" + msg_id);
    $.post(prchatSettings.deleteMessage, {
      id: msg_id
    }).done(function(response) {
      if (response == 'true') {
        $('.tooltipster-base').hide();
        selector.html(prchatSettings.messageIsDeleted).removeClass('tooltipstered');
      }
    });
  }
  /*---------------* Open browser full view chat *---------------*/
  $('#pusherChat .fa.fa-th-large.main_chat').on('click', function() {
    var redirect_url = $('.menu-item-prchat a').attr('href');
    window.location.href = redirect_url;
    return false;
  });
  $('#pusherChat').on('click', '.fa.fa-th-large.user_view', function() {
    var parent_id = $(this).parents('.pusherChatBox').attr('id').replace("id_", "");
    localStorage.staff_to_redirect = parent_id;
    var redirect_url = $('.menu-item-prchat a').attr('href');
    window.location.href = redirect_url;
  });
  /*---------------* Track window resize activity, hides chat when in mobile version *---------------*/
  $(window).resize(function() {
    if ($(window).width() < 733) {
      $('#pusherChat').hide();
    } else {
      $('#pusherChat').show();
    }
  });
  if ($(window).width() < 733) {
    $('#pusherChat').hide();
  } else {
    $('#pusherChat').show();
  }

  /*---------------* Internet connection navigator tracker *---------------*/
  function internetConnectionCheck() {
    return navigator.onLine ? true : false;
  }

  /*---------------* Live internet connection tracking *---------------*/
  function handleConnectionChange(event) {
    var conn_tracker = $('.connection_field');
    if (event.type == "offline") {
      conn_tracker.fadeIn();
      conn_tracker.children('i').addClass('blink');
      conn_tracker.css('background', '#f03d25');
      conn_tracker.children('i').fadeIn();
    }
    if (event.type == "online") {
      conn_tracker.css('background', '#04cc04');
      conn_tracker.children('i').fadeIn();
      conn_tracker.children('i').removeClass('blink');
      conn_tracker.delay(4000).fadeOut(0, function() {
        conn_tracker.children('i').fadeOut();
      });
    }
  }

  $('body').on('click', '.prchat_convertedImage', function() {
    if ($('body').find('.lity-opened')) {
      $('body').find('.lity-opened').remove();
    }
  });

  <?php if (isClientsEnabled()) : ?>
    var clientsChannel = pusher.subscribe('presence-clients');
    clientsChannel.bind('send-event', function(data) {
      if (data.to == 'staff_' + userSessionId) {
        playPushSound();
        if ($('.chatNewMessages').length > 0) {
          var currentCount = parseInt($('.chatNewMessages').text());
          $('.chatNewMessages').text(currentCount += 1);
        } else {
          $("#menu .menu-item-prchat").append('<i class="fa fa-envelope icon_new_messages" data-toggle="tooltip" title="' + prchatSettings.newMessages + '"><span class="chatNewMessages">1</span></i>');
        }
      }
    });
  <?php endif; ?>
</script>