<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script>
    (function() {
        "use strict";
        /*---------------* Pusher Trigger accessing channel *---------------*/
        var clientsChannel = pusher.subscribe('presence-clients');

        var customersUlFirst = '';
        var hiddenUnreadMessages = $('.invisibleUnread');
        var own_image_url = $('.icon.header-user-profile a img').prop("src");
        var clientOffsetPush = 0;
        var clientEndOfScroll = false;
        var lang_customer = "<?= _l('chat_lang_customer'); ?>";
        var lang_contact = "<?= _l('chat_lang_contact'); ?>";

        var f = {
            fetchCustomers: function() {
                var customers = JSON.stringify(<?php get_staff_customers(); ?>);
                return JSON.parse(customers);
            },
            chatAppendCustomers: function(customers) {
                var dfd = new $.Deferred();
                var promise = dfd.promise();
                customers = chatGroupBy(customers, 'client_id');

                if (Object.keys(customers).length === 0) {
                    $('form[name=clientMessagesForm] .message-input').hide();
                    $('.chat_clients_list').append("<li class='text-center m-t-5 cp-5 bg-chat-primary'><h4><?= _l('chat_assigned_contacts'); ?></h4></li>");
                    return false;
                }

                for (var index in customers) {

                    var client_id = client_id = customers[index][0].client_id,
                        company = customers[index][0].company,
                        companyExists = $('ul#client_' + client_id);

                    if (!companyExists.length)
                        $('#crm_clients .chat_clients_list')
                        .append('<ul class="list-group company_selector" id="client_' + client_id + '"><p class="customers_toggler chevron-right">' + company + '</p></ul>');

                    customers[index].forEach(function(contact) {
                        var firstname = contact.firstname,
                            lastname = contact.lastname,
                            contact_id = contact.contact_id;

                        $('#crm_clients .chat_clients_list ul#client_' + client_id)
                            .append('<li class="list-group-item contact_name" id="' + contact_id + '">' + firstname + ' ' + lastname + '</li>');

                    })
                    dfd.resolve(customers);
                }
                promise.then(function() {
                    customersUlFirst = $('.chat_clients_list ul:first');
                    f.initAfterAppendClients();
                });
            },
            initAfterAppendClients: function() {
                // Append client contacts unread messages
                if (customersUlFirst !== '') {
                    customersUlFirst.find('p.customers_toggler').click();
                }
                checkForNewClientUnreadMessages.done(function(r) {
                    if (!r.null) {
                        $.each(r, function(i, sender) {
                            var sender_id = sender.sender_id.replace('client_', '');
                            $('body').find('.contact_name#' + sender_id).append('<span class="client-unread-notifications" data-badge="' + sender.count_messages + '"></span>');
                        });
                    }
                });
            },
            updateUnreadMessages: function(id) {
                $.post(prchatSettings.updateClientUnread, {
                    id: id
                });
            }
        }

        // Get clients and contacts list
        var customerData = f.fetchCustomers();
        if (customerData.customers !== 'none') f.chatAppendCustomers(customerData.customers);


        // DOM Functions
        // Div clients_container functionality for order when clicking
        $('body').on('click', 'p.customers_toggler', function(e) {
            e.preventDefault();
            var $this = $(this);
            var parentUl = $this.parent();
            var hasClassActive = parentUl.hasClass('active');
            parentUl.toggleClass('active');

            if (hasClassActive) {
                parentUl.find('li').animate({
                    opacity: "toggle"
                }, {
                    duration: 200,
                    queue: false
                });
                $this.removeClass('chevron-default').addClass('chevron-right');
            } else {
                parentUl.find('li').animate({
                    opacity: "toggle"
                }, {
                    duration: 200,
                    queue: false
                });
                $this.removeClass('chevron-right').addClass('chevron-default');
            }
        });

        /*---------------* Handle Clients DOM *---------------*/
        $('#frame li.crm_clients a').on('click', function() {

            var hasNotifications = $('.contact_name .client-unread-notifications');

            if (customersUlFirst !== '' && customersUlFirst.find('li:first').length > 0) {
                customersUlFirst.find('li:first').click();
            }

            if (customersUlFirst.length > 0 && !customersUlFirst.hasClass('active')) {
                customersUlFirst.find('.customers_toggler').click();
                hasNotifications.parent().show();
                hasNotifications.parents('ul').addClass('active');
                hasNotifications.parents('ul').children('p.chevron-right').removeClass('chevron-right').addClass('chevron-down');

                var id = customersUlFirst.children('li:first').attr('id');
                f.updateUnreadMessages(id);
            }
            $('#frame form[name=groupMessagesForm],#frame form[name=pusherMessagesForm],#frame .content .group_messages, #frame .groupOptions').hide();
            $('#frame .chat_group_options.active').hide().removeClass('active');

            $('#search #search_field').attr('id', 'search_clients_field');
            $('#search #search_clients_field').attr('placeholder', '<?= _l('chat_search_customers'); ?>');

            chat_contact_profile_img.hide();
            chat_contact_profile_img.next().hide();
            chat_contact_profile_img.next().next().hide();
            chat_social_media.hide();
            chat_content_messages.hide();
            chat_client_messages.show();

            $('.group_members_inline').remove();

            // // Hide staff chatbox form
            $('#frame #pusherMessagesForm, #sharedFiles').hide();
            $(this).removeClass('flashit');

            $('#frame .content .client_messages, #frame form[name=clientMessagesForm]').show();

        });

        /*---------------* Search customers *---------------*/
        $("body").on("keyup", '#search_clients_field', function(e) {
            var value = $.trim($(this).val().toLowerCase());
            if (value == '') {
                $("#frame #crm_clients ul").show();
                return;
            }
            var key = e.keyCode || e.which;
            var crmClientsParent = $('#crm_clients ul');
            var crmClientsChildren = $('#crm_clients ul li');
            var removeClassActive = $('#crm_clients ul').removeClass('active');

            if (key == 8 || key == 46)
                crmClientsChildren.hide() &&
                crmClientsParent.show();

            if (e.keyCode === 27 || e.which == 27) {
                $('#search_clients_field').val('');
                crmClientsChildren.hide();
                crmClientsParent.show();
                return false;
            }

            if (value.length > 0) {
                $("#frame  #crm_clients ul").each(function() {
                    if ($(this).find('li').prev().text().toLowerCase().indexOf(value) > -1 ||
                        $(this).find('li.contact_name').text().toLowerCase().indexOf(value) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });

        /*--------------------  * send message & typing event to server  * ------------------- */
        $("#frame").on('keypress', 'textarea.client_chatbox', function(e) {
            var form = $('form[name=clientMessagesForm]');
            var imgPath = $('#sidepanel #profile .wrap img').prop('currentSrc');

            if (e.which == 13) {
                e.preventDefault();
                var message = $.trim($(this).val());

                if (message == '' || internetConnectionCheck() === false) {
                    return false;
                }

                message = createTextLinks_(emojify.replace(message));

                $('.client_messages .chat_client_messages ul').append('<li class="sent" id="' + userSessionId + '"><img class="myProfilePic" src="' + imgPath + '"/><p class="you" data-toggle="tooltip" title="' + moment().format('hh:mm A') + '" id="' + userSessionId + '">' + message + '</p></li>');
                $(this).next().next().next().val('false');
                message = escapeHtml(message);
                // send event 
                var formData = form.serializeArray();

                $.post(prchatSettings.clientsMessagesPath, formData);
                $(this).val('').focus();
                scroll_event();
            } else if (!$(this).val() || ($(this).next().next().next().val() == 'null' && $(this).val())) {
                // typing event 
                $(this).next().next().next().val('true');
                $.post(prchatSettings.clientsMessagesPath, form.serialize());
            }
        });

        /*---------------* Check for unread frontend *---------------*/
        $("#frame").on("focus", ".client_chatbox", function() {
            var id = $('.client_messages').attr('id');
            if (id !== '') {
                id.replace('client_', '');
                if (hiddenUnreadMessages.val() > 0) {
                    f.updateUnreadMessages(id);
                    hiddenUnreadMessages.val('0');
                }
            }
        });

        // Init Crm clients messages view 
        $(function() {
            var $previous = $('.company_selector > li').click(function() {
                $previous.removeClass('selected');
                $(this).addClass('selected')
            });
        });


        var createChatBoxClientRequest = null;

        function getClientMessages(staff_id, client_id, contact) {
            var notificationDiv = contact.children('.client-unread-notifications');
            var notificationLength = contact.children('.client-unread-notifications');
            if (notificationLength.length > 0) {
                // Update messages in database  make function
                notificationDiv.remove();
            }
            $("#no_messages").remove();
            $('.group_members_inline').remove();

            var deferred = $.Deferred();
            var promise = deferred.promise();

            if (createChatBoxClientRequest) {
                createChatBoxClientRequest.abort();
                deferred.resolve([]);
            } else {
                createChatBoxClientRequest = $.get(prchatSettings.getMutualMessages, {
                        reciever_id: 'staff_' + staff_id,
                        sender_id: 'client_' + client_id,
                        offset: 0,
                        limit: 20
                    })
                    .done(function(messages) {
                        clientOffsetPush = 10;


                        clientOffsetPush += 10;
                        deferred.resolve(messages);

                    }).always(function() {
                        if ($("#no_messages").length > 0) {
                            $("#no_messages").remove();
                        }
                        createChatBoxClientRequest = null;
                    });
            }

            /*---------------* After users are fetched from database -> continue with loading *---------------*/
            promise.then(function(messages) {
                var clientUl = $('.client_messages ul');

                $(messages).each(function(key, value) {
                    value.message = emojify.replace(value.message);
                    (value.sender_id == 'staff_' + staff_id) ?
                    clientUl.prepend('<li class="sent"><img class="myProfilePic" src="' + own_image_url + '"/><p class="you" data-toggle="tooltip" data-container="body" data-placement="left" title="' + value.time_sent_formatted + '" id="msg_' + value.id + '">' + value.message + '</p></li>'): clientUl.prepend('<li class="replies"><img class="clientProfilePic" src="' + value.client_image_path + '"/><p  class="client" data-toggle="tooltip" data-container="body" data-placement="right" title="' + value.time_sent_formatted + '">' + value.message + '</p></li>');
                });

                $('.group_members_inline').remove();
            });

            activateLoader(promise, true);

            $.when(promise)
                .then(function() {
                    ($(".client_messages").hasScrollBar())
                    scroll_event();
                    $('.client_chatbox').focus();
                });
            return false;
        }


        /*---------------* Check for messages history and append to main chat window *---------------*/
        $('.client_messages').on('scroll', function() {

            var pos = $(this).scrollTop();
            var client_id = $(this).attr("id");
            var to = $('#clients_container li.contact_name.selected').attr('id');

            var defScroll = $.Deferred();
            var promise = defScroll.promise();

            if (pos == 0 && clientOffsetPush >= 10) {

                $.get(prchatSettings.getMutualMessages, {
                        reciever_id: client_id,
                        sender_id: 'staff_' + userSessionId,
                        offset: clientOffsetPush,
                    })
                    .done(function(messages) {
                        if (Array.isArray(messages) === false) {
                            clientEndOfScroll = true;
                            $('#frame .client_messages').find('.message_loader').hide();
                            if ($('.client_messages').hasScrollBar() && clientEndOfScroll == true) {
                                prchat_setNoMoreMessages();
                            }
                        } else {
                            clientOffsetPush += 10;
                            defScroll.resolve(messages);
                        }

                        $(messages).each(function(key, value) {
                            var clientUl = $('.client_messages ul');
                            value.message = emojify.replace(value.message);
                            (value.sender_id == 'staff_' + userSessionId) ?
                            clientUl.prepend('<li class="sent"><img class="myProfilePic" src="' + own_image_url + '"/><p class="you" data-toggle="tooltip" data-container="body" data-placement="left" title="' + value.time_sent_formatted + '" id="msg_' + value.id + '">' + value.message + '</p></li>'): clientUl.prepend('<li class="replies"><img class="clientProfilePic" src="' + value.client_image_path + '"/><p  class="client" data-toggle="tooltip" data-container="body" data-placement="right" title="' + value.time_sent_formatted + '">' + value.message + '</p></li>');
                        });
                        if (clientEndOfScroll === false) {
                            $('.client_messages').scrollTop(200);
                        }
                    });
                if (!clientEndOfScroll === true) {
                    activateLoader(promise, true);
                }
            }
        });

        // File upload 
        $('#frame').on('click', '.clientFileUpload', function() {
            $('#frame').find('form[name="clientFileForm"] input:first').click();
        });

        //  Show All Contacts
        var chatCs = $('.chat_clients_list ul.company_selector');
        var chatCsLi = $('.chat_clients_list ul.company_selector li');
        $('#frame').on('click', '#clients_show', function() {
            chatCs.children('p').addClass('chevron-default').removeClass('chevron-right');
            chatCsLi.slideDown('400');
        });

        // Hide all contacts
        $('#frame').on('click', '#clients_hide', function() {
            chatCs.children('p').removeClass('chevron-default').addClass('chevron-right')
            chatCsLi.slideUp('400');
        });

        /*---------------* Event that handles when clicked on a specific contact in sidebar *---------------*/
        $('#clients_container').on('click', '.contact_name', function(e) {
            e.preventDefault();

            if ($(this).children('.client-unread-notifications').length > 0)
                f.updateUnreadMessages($(this).attr('id'));

            // Clear messages
            chat_client_messages.html('');
            chat_client_messages.append('<ul></ul>');

            // Reset offset and end of scroll
            clientOffsetPush = 0;
            clientEndOfScroll = false;

            var contactId = $(this).attr('id'),
                clientName = $(this).text(),
                customerName = $(this).parent().find('.customers_toggler').text(),
                contactProfile = $('#frame .contact-profile'),
                clientId = $(this).parent().attr('id').replace('client_', ''),
                clientData = '';

            $('.client_data').remove();
            $('.client_messages').attr('id', 'client_' + contactId);
            $('.client_messages').addClass('isFocused');

            $('form#clientMessagesForm .to').val('client_' + contactId);
            $('form#clientMessagesForm .from').val('staff_' + userSessionId);

            getClientMessages(userSessionId, contactId, $(this));

            clientData += '<div class="client_data">';
            clientData += '<p> ' + lang_customer + ' <a href="' + site_url + 'admin/clients/client/' + clientId + '" target="_blank"><strong>' + customerName + ' </strong></a></p>';
            clientData += '<span class="contact_lang"> ' + lang_contact + ' <a href="' + site_url + 'admin/clients/client/' + clientId + '?group=contacts&contactid=' + contactId + '" target="_blank""><strong>' + clientName + ' </strong></a></span>';
            clientData += '</div>';
            contactProfile.prepend(clientData);
        });

        /*---------------* Member array for online / offline activity *---------------*/
        var pendingRemoves = [];
        /*---------------* Pusher Trigger user subscribed successfully *---------------*/
        clientsChannel.bind('pusher:subscription_succeeded', function(member) {
            $('#main_loader_init').fadeOut(500);
            pusherNewClientMember(member);
        });

        /*---------------* Pusher Trigger user logout *---------------*/
        clientsChannel.bind('pusher:member_removed', function(member) {
            removeClientMember(member);
        });

        /*---------------* Pusher Trigger user connected *---------------*/
        clientsChannel.bind('pusher:member_added', function(member) {
            addClientMember(member);
        });

        /*---------------* New staff member activity online / offline  *---------------*/
        function pusherNewClientMember() {
            var c = f.fetchCustomers();
            for (var i = 0; i < c.customers.length; i++) {
                var user = clientsChannel.members.get('client_' + c.customers[i].client_id);
                if (user !== null) {
                    $('body').find('.company_selector .contact_name#' + c.customers[i].client_id).addClass('contactActive');
                }
            };
        }

        /*---------------* New chat members tracking / removing *---------------*/
        function addClientMember(member) {
            var member = member.id.replace('client_', '');
            var pendingRemoveTimeout = pendingRemoves[member.id];
            $('body').find('.company_selector .contact_name#' + member).addClass('contactActive');
            var c = f.fetchCustomers();
            for (var i = 0; i < c.customers.length; i++) {
                var user = clientsChannel.members.get('client_' + c.customers[i].client_id);
                if (user !== null) {
                    if (user.info.justLoggedIn) {
                        $.notify('', {
                            'title': app.lang.new_notification,
                            'body': lang_contact + ' ' + user.info.name + ' ' + prchatSettings.hasComeOnlineText,
                            'requireInteraction': true,
                            'tag': 'contact-join-' + user.id,
                            'closeTime': 5000,
                        });
                    }
                }
            };
            if (pendingRemoveTimeout) {
                clearTimeout(pendingRemoveTimeout);
            }
        }

        /*---------------* New chat members tracking / removing from channel and UX*---------------*/
        function removeClientMember(member) {
            var member = member.id.replace('client_', '');
            pendingRemoves[member.id] = setTimeout(function() {
                $('body').find('.company_selector .contact_name#' + member).removeClass('contactActive');
            }, 5000);
        }

        /*---------------* Bind the 'send-event' & update the chat box message log *---------------*/
        var invisibleCounter = 1;
        clientsChannel.bind('send-event', function(data) {
            $('#frame .client_messages').find('span.userIsTyping').fadeOut(500);

            var selectedContact = $('.chat_clients_list ul.active li.selected');

            selectedContact = 'client_' + selectedContact.attr('id');

            if (selectedContact == data.from && data.to == 'staff_' + userSessionId) {
                data.message = createTextLinks_(emojify.replace(data.message));
                $('.client_messages#' + data.from + ' .chat_client_messages ul').append('<li class="replies"><img class="clientProfilePic" src="' + data.client_image_path + '"/><p class="client" data-toggle="tooltip" title="' + moment().format('hh:mm A') + '">' + data.message + '</p></li>');
                parseInt(hiddenUnreadMessages.val(invisibleCounter++));
                scroll_event();
            } else if (data.to == 'staff_' + userSessionId) {
                data.from = data.from.replace('client_', '');
                var contactNotification = $('body').find('.contact_name#' + data.from);

                var cNotName = '.client-unread-notifications';
                $('.crm_clients:not(.active) a').addClass('flashit');
                initClientSound(data);
                if (!contactNotification.find(cNotName).length) {
                    $('body').find('.contact_name#' + data.from).append('<span class="client-unread-notifications" data-badge="1"></span>');
                    contactNotification.parent('ul').addClass('active');
                    contactNotification.show();
                } else {
                    var currentNotifications = parseInt(contactNotification.find(cNotName).attr('data-badge'));
                    contactNotification.find(cNotName).attr('data-badge', currentNotifications + 1);
                }

            }
        });
        /*---------------* Detect when a user is typing a message *---------------*/
        clientsChannel.bind('typing-event', function(data) {
            var clearTypingInterval = 2500; // 2.2 seconds
            var clearTypingTimerId;
            var clientMessages = $('#frame .client_messages');
            var selectedContact = $('.chat_clients_list ul.active li.selected');
            selectedContact = 'client_' + selectedContact.attr('id');

            if (clientMessages.hasClass('isFocused') &&
                data.from === selectedContact &&
                data.to == 'staff_' + userSessionId &&
                data.message == 'true') {
                clientMessages.find('.userIsTyping').fadeIn(500);
                clearTimeout(clearTypingTimerId);
                clearTypingTimerId = setTimeout(function() {
                    clientMessages.find('.userIsTyping').fadeOut(500);
                }, clearTypingInterval);
                clientMessages.find('span.userIsTyping').fadeIn(500);
            } else if (
                clientMessages.hasClass('isFocused') &&
                data.from === selectedContact &&
                data.to == 'staff_' + userSessionId &&
                data.message == 'true') {
                clientMessages.find('span.userIsTyping').fadeOut(500);
            }
        });

        $('body').on('click', '.prchat_convertedImage', function() {
            if ($('body').find('.lity-opened')) {
                $('body').find('.lity-opened').remove();
            }
        });
    }());

    // Handles client file form upload 
    function uploadClientFileForm(form) {
        var formData = new FormData();
        var fileForm = $(form).children('input[type=file]')[0].files[0];
        var sentTo = $('.company_selector.active').attr('id');
        var token_name = $(form).children('input[name=csrf_token_name]').val();
        var formId = $(form).attr('id');

        formData.append('userfile', fileForm);
        formData.append('send_to', sentTo);
        formData.append('send_from', 'staff_' + userSessionId);
        formData.append('csrf_token_name', token_name);

        $.ajax({
            type: 'POST',
            url: prchatSettings.uploadMethod,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
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
            success: function(r) {
                if (!r.error) {
                    var uploadSend = $.Event("keypress", {
                        which: 13
                    });
                    var basePath = "<?php echo base_url('modules/prchat/uploads/'); ?>";
                    $('#frame textarea.client_chatbox').val(basePath + r.upload_data.file_name);
                    setTimeout(function() {
                        if ($('#frame textarea.client_chatbox ').trigger(uploadSend)) {
                            alert_float('info', 'File ' + r.upload_data.file_name + ' sent.');
                            $('.content .chat-module-loader').fadeOut();
                        }
                    }, 100);
                } else {
                    $('.content .chat-module-loader').fadeOut();
                    alert_float('danger', r.error);
                }
            }
        });
        $('form#' + formId).trigger("reset");
    }

    /*!
     * Group items from an array together by some criteria or value.
     * @param  {Array}           arr      The array to group items from
     * @param  {String|Function} criteria The criteria to group by
     * @return {Object}                   The grouped object
     */

    function chatGroupBy(arr, criteria) {
        return arr.reduce(function(obj, item) {
            // Check if the criteria is a function to run on the item or a property of it
            var key = typeof criteria === 'function' ? criteria(item) : item[criteria];

            // If the key doesn't exist yet, create it
            if (!obj.hasOwnProperty(key)) {
                obj[key] = [];
            }

            // Push the value to the object
            obj[key].push(item);

            // Return the object to the next item in the loop
            return obj;

        }, {});
    };
</script>