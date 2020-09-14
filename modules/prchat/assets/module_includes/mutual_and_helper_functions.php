<script>
    /**
     * Main Settings for clients chat
     * Used in chat_clients_view.php
     */
    var customerSettings = {
        'clientPusherAuth': '<?php echo site_url('prchat/Prchat_ClientsController/pusherCustomersAuth'); ?>',
        'getMutualMessages': '<?php echo site_url('prchat/Prchat_ClientsController/getMutualMessages'); ?>',
        'clientsMessagesPath': '<?php echo site_url('prchat/Prchat_ClientsController/initClientChat'); ?>',
        'getStaffUnreadMessages': '<?php echo site_url('prchat/Prchat_ClientsController/getStaffUnreadMessages'); ?>',
        'updateStaffUnread': '<?php echo site_url('prchat/Prchat_ClientsController/updateClientUnreadMessages'); ?>',
        'hasComeOnlineText': "<?php echo _l('chat_user_is_online'); ?>",
        'noMoreMessagesText': "<?php echo _l('chat_no_more_messages_to_show'); ?>",
        'uploadMethod': '<?php echo site_url('prchat/Prchat_ClientsController/uploadMethod'); ?>',
        'debug': <?php if (ENVIRONMENT != 'production') { ?> true <?php } else { ?> false <?php }; ?>,
    };

    /*---------------* Parse emojies in chat area do not touch *---------------*/
    emojify.setConfig({
        emojify_tag_type: 'div',
        'img_dir': site_url + '/modules/prchat/assets/chat_implements/emojis'
    });
    emojify.run();

    /*-------* Lity prevent duplicating images in click *-------*/
    $('body').on('click', '.prchat_convertedImage', function() {
        if ($('body').find('.lity-opened')) {
            $('body').find('.lity-opened').remove();
        }
    });


    /*-------* Simple enter key function *-------*/
    $.fn.enterKey = function(fnc) {
        return this.each(function() {
            $(this).keypress(function(e) {
                var keycode = (e.keyCode ? e.keyCode : e.which);
                if (keycode == '13') {
                    fnc.call(this, e);
                }
            })
        })
    };

    /*-------* Live internet connection tracker *-------*/
    function internetConnectionCheck() {
        return navigator.onLine ? true : false;
    }

    /*---------------* Security escaping html in chatboxes prevent database injection *---------------*/
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/'/g, '&#039;');
    }

    /*---------------* Check messages if contains any links or images *---------------*/
    function createTextLinks_(text) {
        var regex = (/\.(gif|jpg|jpeg|tiff|png|swf)$/i);
        return (text || "").replace(/([^\S]|^)(((https?\:\/\/)|(www\.))(\S+))/gi, function(match, string, url) {
            var hyperlink = url;
            if (!hyperlink.match('^https?:\/\/')) {
                hyperlink = '//' + hyperlink;
            }
            if (hyperlink.match('^http?:\/\/')) {
                hyperlink = hyperlink.replace('http://', '//');
            }
            if (hyperlink.match(regex)) {
                return string + '<a href="' + hyperlink + '" target="blank" data-lity><img class="prchat_convertedImage" src="' + hyperlink + '"/></a>';
            } else {
                return string + '<a data-lity target="blank" href="' + hyperlink + '">' + url + '</a>';
            }
        });
    }

    /*---------------* Capitalize first string of letter *---------------*/
    function strCapitalize(string) {
        if (string != undefined) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }


    /*---------------* Function that handles clients events after clicked back to .crm_clients in tabs *---------------*/
    function clientsListCheck() {
        $('.client_messages').removeClass('isFocused');
        $('body').find('.contact_name.selected').removeClass('selected');
    }

    /*---------------* Get user avatar picture *---------------*/
    function fetchUserAvatar(id, image_name) {
        var type = 'small';
        var url = site_url + '/assets/images/user-placeholder.jpg';
        if (image_name == false) {
            return url;
        }
        if (image_name != null) {
            url = site_url + '/uploads/staff_profile_images/' + id + '/' + type + '_' + image_name;
        } else {
            url = site_url + '/assets/images/user-placeholder.jpg';
        }
        return url;
    }

    /*---------------* Check if element has scrollbar *---------------*/
    (function($) {
        $.fn.hasScrollBar = function() {
            return this.get(0).scrollHeight > this.get(0).clientHeight;
        }
    })(jQuery);

    /*---------------* Set no more messages if not found in database *---------------*/
    // Used in chat_full_view.php
    function prchat_setNoMoreMessages() {
        if ($("#no_messages").length == 0) {

            $('.client_messages').prepend('<div class="text-center mtop5" id="no_messages">' + prchatSettings.noMoreMessagesText + '</div>');

            $('.messages').prepend('<div class="text-center mtop5" id="no_messages">' + prchatSettings.noMoreMessagesText + '</div>');
        }
    }
    // Used in chat_full_view.php
    function prchat_setNoMoreGroupMessages() {
        if ($("#no_messages").length == 0) {
            $('.group_messages .chat_group_messages').prepend('<div class="text-center mtop5" id="no_messages">' + prchatSettings.noMoreMessagesText + '</div>');
        }
    }
    // Used in chat_clients_view.php
    function prchat_setNoMoreStaffMessages() {
        if ($("#no_messages").length == 0) {
            $('.m-area').prepend('<div class="text-center mtopbottomfixed" id="no_messages">' + customerSettings.noMoreMessagesText + '</div>');
        }
    }

    /*---------------* Chat shortcuts for better user experience Ctrl+Alt+Z and Ctrl+Alt+S *---------------*/
    $(document).keydown(function(e) {
        if ((e.which === 90 || e.keyCode == 90) && e.ctrlKey && e.altKey) {
            $(".messages").animate({
                scrollTop: $('.messages').prop("scrollHeight")
            }, 500);
        }
        if ((e.which === 83 || e.keyCode == 83) && e.ctrlKey && e.altKey) {
            $('#frame').find('#search_field').focus();
        }
        if ((e.which === 70 || e.keyCode == 70) && e.ctrlKey && e.altKey) {
            if ($('#shared_user_files').is(':visible')) {
                $('#shared_user_files').click();
            }
        }
    });

    $(window).resize(function() {
        // Mobile version not allowed due to better client staff contact in full view only
        ($(window).width() < 768) ?
        $('#clientChat, .ch_pointer').hide():
            $('#clientChat, .ch_pointer').show();
        // Clients mobile version not allowed due to better client staff contact in full view only
        if ($(window).width() < 768) {
            if ($('#crm_clients').hasClass('active')) {
                $('#frame .staff a').click();
            }
        }
    });

    if ($(window).width() > 733) {
        $('#switchTheme, #shared_user_files, #announcement, #frame .groupOptions').show();
        $('body').removeClass('hide-sidebar').addClass('show-sidebar');
    } else {
        $('#switchTheme, #sharedFiles, #shared_user_files, #announcementm, #frame .groupOptions').hide();
        $('body').removeClass('show-sidebar').addClass('hide-sidebar');
    }
</script>