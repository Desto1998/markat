<?php

/*
Module Name: Perfex CRM Chat
Description: Chat Module for Perfex CRM
Author: Aleksandar Stojanov
Author URI: https://idevalex.com
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Prchat_model extends App_Model
{
    /**
     * Get chat staff members
     * @return mixed
     */
    public function getUsers()
    {
        $data = [];
        $user = get_staff(get_staff_user_id());

        $this->db->select('staffid, firstname, lastname, profile_image, last_login, facebook,  role, linkedin, skype, admin');
        $this->db->where('active', 1);

        if ($user->role != 2) {
            $this->db->where('role', 2);
        } else {
            $this->db->where('role != 9999');
        }

        $users = $this->db->get(db_prefix() . 'staff')->result_array();

        foreach ($users as $key => $user) {
            $sql = "SELECT message,sender_id,time_sent FROM " . db_prefix() . "chatmessages WHERE (sender_id = " . get_staff_user_id() . " AND reciever_id = {$user['staffid']}) OR (sender_id = {$user['staffid']} AND reciever_id = " . get_staff_user_id() . ") ORDER BY id DESC LIMIT 0, 1";

            $query = $this->db->query($sql)->result();

            foreach ($query as &$chat) {
                $users[$key]['time_sent_formatted'] = $chat->time_sent_formatted = time_ago($chat->time_sent);
                if ($user['staffid'] !== $chat->sender_id) {
                    $users[$key]['message'] = _l('chat_message_you') . ' ' . $chat->message;
                } else {
                    $users[$key]['message'] = $chat->message;
                }
            }
        }

        if ($users) {
            return $users;
        }
        return false;
    }

    /**
     * Get logged in staff profile image
     * @param mixed
     * @return mixed
     */
    public function getUserImage($id)
    {
        $CI = &get_instance();
        $CI->db->from(db_prefix() . 'staff');
        $CI->db->where('staffid', $id);
        $data = $CI->db->get()->row('profile_image');

        if ($data) {
            return $data;
        }

        return false;
    }

    /**
     * Create message
     * @param data
     * @return boolean
     */
    public function createMessage($data)
    {
        if ($this->db->insert(db_prefix() . 'chatmessages', $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Create group message
     * @param data
     * @return boolean
     */
    public function createGroupMessage($data)
    {
        if ($this->db->insert(db_prefix() . 'chatgroupmessages', $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Get staff firstname and lastname
     * @param mixed
     * @return mixed
     */
    public function getStaffInfo($id)
    {
        $this->db->select('firstname,lastname');
        $this->db->where('staffid', $id);
        $result = $this->db->get(db_prefix() . 'staff')->row();
        if ($result) {
            return $result;
        }

        return false;
    }

    /**
     * @param  $from sender
     * @param  $to receiver
     * @param  $limit limit messages
     * @param  $offet offset
     * @return mixed
     */
    public function getMessages($from, $to, $limit, $offset)
    {
        $sql = "SELECT * FROM " . db_prefix() . "chatmessages WHERE (sender_id = {$to} AND reciever_id = {$from}) OR (sender_id = {$from} AND reciever_id = {$to}) ORDER BY id DESC LIMIT {$offset}, {$limit}";

        $query = $this->db->query($sql)->result();

        foreach ($query as &$chat) {
            $chat->message = html_entity_decode($chat->message);
            $chat->message = pr_chat_convertLinkImageToString($chat->message);
            $chat->message = check_for_links_lity($chat->message);
            $chat->user_image = $this->getUserImage($chat->sender_id);
            $chat->sender_fullname = get_staff_full_name($chat->sender_id);
            $chat->time_sent_formatted = _dt($chat->time_sent);
        }

        if ($query) {
            return $query;
        }

        return false;
    }

    /**
     * @param  $from sender
     * @param  $to receiver
     * @param  $limit limit messages
     * @param  $offet offset
     * @return mixed
     */
    public function getMutualMessages($from, $to, $limit, $offset)
    {

        $sql = "SELECT * FROM " . db_prefix() . "chatclientmessages WHERE (sender_id = '{$to}' AND reciever_id = '{$from}') OR (sender_id = '{$from}' AND reciever_id = '{$to}') ORDER BY id DESC LIMIT {$offset}, {$limit}";


        $query = $this->db->query($sql)->result();

        foreach ($query as &$chat) {
            $chat->message = html_entity_decode($chat->message);
            $chat->message = pr_chat_convertLinkImageToString($chat->message);
            $chat->message = check_for_links_lity($chat->message);
            $chat->sender_fullname = get_staff_full_name(str_replace('staff_', '', $chat->sender_id));
            $chat->client_image_path = contact_profile_image_url(str_replace('client_', '', $chat->sender_id));
            $chat->time_sent_formatted = _dt($chat->time_sent);
        }

        if ($query) {
            return $query;
        }

        return false;
    }

    /**
     * @param  $group_id group_id
     * @param  $limit limit messages
     * @param  $offet offset
     * @return mixed
     */
    public function getGroupMessages($group_id, $limit, $offset)
    {
        if ($group_id !== null) {
            $sql = "SELECT * FROM " . db_prefix() . "chatgroupmessages WHERE group_id = {$group_id} ORDER BY id DESC LIMIT {$offset}, {$limit}";

            $query = $this->db->query($sql)->result();
            $created_by = $this->db->get_where(db_prefix() . 'chatgroups', ['id' => $group_id])->row('created_by_id');

            foreach ($query as &$chat) {
                $chat->message = pr_chat_convertLinkImageToString($chat->message);
                $chat->message = check_for_links_lity($chat->message);
                $chat->user_image = $this->getUserImage($chat->sender_id);
                $chat->sender_fullname = get_staff_full_name($chat->sender_id);
                $chat->time_sent_formatted = _dt($chat->time_sent);
                $chat->created_by_id = $created_by;
            }

            $newQuery['messages'] = $query;

            $this->db->select('member_id,  group_id, lastname, firstname, created_by_id');
            $this->db->from(TABLE_CHATGROUPMEMBERS);
            $this->db->where('group_id', $group_id);
            $this->db->join(TABLE_STAFF, '' . TABLE_STAFF . '.staffid=' . TABLE_CHATGROUPMEMBERS . '.member_id');
            $this->db->join(TABLE_CHATGROUPS, '' . TABLE_CHATGROUPS . '.id=' . TABLE_CHATGROUPMEMBERS . '.group_id');
            $result = $this->db->get();
            $newQuery['users'] = $result->result_array();

            $group_name = $this->db->get_where(TABLE_CHATGROUPS, ['id' => $group_id])->row('group_name');

            $newQuery['separete_group_id'] = $group_id;
            $newQuery['separete_group_name'] = $group_name;

            if ($newQuery) {
                return $newQuery;
            }
        } else {
            return false;
        }

        return false;
    }

    /**
     * @param  $group_id group_id
     * @param  $limit limit messages
     * @param  $offet offset
     * @return mixed
     */
    public function getGroupMessagesHistory($group_id, $limit, $offset)
    {
        $sql = "SELECT * FROM " . db_prefix() . "chatgroupmessages WHERE group_id = {$group_id} ORDER BY id DESC LIMIT {$offset}, {$limit}";

        $query = $this->db->query($sql)->result();
        $created_by = $this->db->get_where(db_prefix() . 'chatgroups', ['id' => $group_id])->row('created_by_id');

        foreach ($query as &$chat) {
            $chat->message = pr_chat_convertLinkImageToString($chat->message);
            $chat->message = check_for_links_lity($chat->message);
            $chat->user_image = $this->getUserImage($chat->sender_id);
            $chat->sender_fullname = get_staff_full_name($chat->sender_id);
            $chat->time_sent_formatted = _dt($chat->time_sent);
            $chat->created_by_id = $created_by;
        }

        if ($query) {
            return $query;
        }

        return false;
    }


    /**
     * Get unread messages for the logged in user
     */
    public function getUnread()
    {
        $unreadMessages = array();

        $staff_id = get_staff_user_id();

        $sql = "SELECT sender_id FROM " . db_prefix() . "chatmessages WHERE(reciever_id = $staff_id AND viewed = 0)";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->result_array();

            foreach ($result as $sender) {
                $sender_id = 'sender_id_' . $sender['sender_id'];
                if (array_key_exists($sender_id, $unreadMessages)) {
                    $unreadMessages['' . $sender_id . '']['count_messages'] = $unreadMessages['' . $sender_id . '']['count_messages'] + 1;
                } else {
                    $unreadMessages['' . $sender_id . ''] = array('sender_id' => $sender['sender_id'], 'count_messages' => 1);
                }
            }
            if ($result) {
                return $unreadMessages;
            }
        }

        return false;
    }

    /**
     * Get client unread messages for the logged in user / admin
     */
    public function getClientUnreadMessages()
    {

        $unreadMessages = array();

        $staff_id = 'staff_' . get_staff_user_id();

        $sql = "SELECT sender_id FROM " . db_prefix() . "chatclientmessages WHERE(reciever_id = '{$staff_id}' AND viewed = 0)";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->result_array();

            foreach ($result as $sender) {
                $sender_id = '_' . $sender['sender_id'];
                if (array_key_exists($sender_id, $unreadMessages)) {
                    $unreadMessages['' . $sender_id . '']['count_messages'] = $unreadMessages['' . $sender_id . '']['count_messages'] + 1;
                } else {
                    $unreadMessages['' . $sender_id . ''] = array('sender_id' => $sender['sender_id'], 'count_messages' => 1);
                }
            }
            if ($result) {
                return $unreadMessages;
            }
        }

        return false;
    }

    /**
     * Get client unread messages for the logged in user / admin
     */
    public function getStaffUnreadMessages()
    {

        $unreadMessages = array();

        $contact_id = 'client_' . get_contact_user_id();

        $sql = "SELECT sender_id FROM " . db_prefix() . "chatclientmessages WHERE(reciever_id = '{$contact_id}' AND viewed = 0)";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->result_array();

            foreach ($result as $sender) {
                $sender_id = '_' . $sender['sender_id'];
                if (array_key_exists($sender_id, $unreadMessages)) {
                    $unreadMessages['' . $sender_id . '']['count_messages'] = $unreadMessages['' . $sender_id . '']['count_messages'] + 1;
                } else {
                    $unreadMessages['' . $sender_id . ''] = array('sender_id' => $sender['sender_id'], 'count_messages' => 1);
                }
            }
            if ($result) {
                return $unreadMessages;
            }
        }

        return false;
    }

    /**
     * Update unread for sender
     * @param mixed $id sender id
     * @return mixed
     */
    public function updateUnread($id)
    {
        $staff_id = get_staff_user_id();
        $sql = "UPDATE " . db_prefix() . "chatmessages SET viewed = 1 WHERE (reciever_id = $staff_id AND sender_id = {$id})";
        $query = $this->db->query($sql);
        if ($query) {
            return $query;
        }
        return false;
    }

    /**
     * Update unread for client sender
     * @param mixed $id sender id
     * @return mixed
     */
    public function updateClientUnreadMessages($id, $client = null)
    {
        if ($client !== null) {
            $user_id = get_contact_user_id();
            $sql = "UPDATE " . db_prefix() . "chatclientmessages SET viewed = 1 WHERE (reciever_id = 'client_{$user_id}' AND sender_id = '{$id}')";
        } else {
            $user_id = get_staff_user_id();
            $sql = "UPDATE " . db_prefix() . "chatclientmessages SET viewed = 1 WHERE (reciever_id = 'staff_{$user_id}' AND sender_id = 'client_{$id}')";
        }

        $query = $this->db->query($sql);
        if ($query) {
            return $query;
        }
        return false;
    }

    /**
     * Set theme
     * @param mixed $id the staff id
     * @param string $theme_name 1 or 0 light or dark
     */
    public function updateChatTheme($id, $theme_name)
    {
        $name = 'current_theme';
        $this->db->where('user_id', $id);
        $this->db->where('name', $name);

        $exsists = $this->db->get(db_prefix() . 'chatsettings')->row();

        if (!$exsists == null) {
            $this->db->where('user_id', $id);
            $this->db->where('name', $name);
            $this->db->update(db_prefix() . 'chatsettings', array('name' => $name, 'value' => $theme_name));
        } else {
            $this->db->insert(db_prefix() . 'chatsettings', array('name' => $name, 'value' => $theme_name, 'user_id' => $id));
        }
        if ($this->db->affected_rows() != 0) {
            return $theme_name;
        }
        return $theme_name;
    }

    /**
     * Reset toggled chat theme colors
     * @param  [type] $id user id
     * @return boolean
     */
    public function resetChatColors($id)
    {
        $this->db->where('user_id', $id);
        $this->db->update(db_prefix() . 'chatsettings', [
            'name' => 'chat_color',
            'value' => '#546bf1'
        ]);
        return true;
    }

    /**
     * Set the chat color
     * @param mixed $id the staff id
     * @param string $color the color to set
     */
    public function setChatColor($color)
    {
        $id = get_staff_user_id();
        $name = 'chat_color';

        $color = validateChatColorBeforeApply($color, true);

        if ($color === 'unknownColor') {
            $message['success'] = $color;
            return $message;
        }

        if ($this->db->field_exists('value', db_prefix() . 'chatsettings')) {
            $this->db->where('user_id', $id);
            $this->db->where('name', $name);
            $exsists = $this->db->get(db_prefix() . 'chatsettings')->row();
            if (!$exsists == null) {
                $this->db->where('user_id', $id);
                $this->db->where('name', $name);
                $this->db->update(db_prefix() . 'chatsettings', array('name' => $name, 'value' => $color));
            } else {
                $this->db->insert(db_prefix() . 'chatsettings', array('name' => $name, 'value' => $color, 'user_id' => $id));
            }
            if ($this->db->affected_rows() != 0) {
                $message['success'] = $color;
                return $message;
            }
            $message['success'] = false;
            return $message;
        } else {
            $this->db->where('user_id', $id);
            $this->db->where('name', $name);
            $exsists = $this->db->get(db_prefix() . 'chatsettings')->row();
            if (!$exsists == null) {
                $this->db->where('user_id', $id);
                $this->db->where('name', $name);
                $this->db->update(db_prefix() . 'chatsettings', array('chat_color' => $color));
            } else {
                $this->db->insert(db_prefix() . 'chatsettings', array('chat_color' => $color, 'user_id' => $id));
            }
            if ($this->db->affected_rows() != 0) {
                $message['success'] = $color;
                return $message;
            }
            $message['success'] = false;
            return $message;
        }
    }


    /**
     * Delete group shared files from folder
     * @param $group_id
     * @return boolean
     */
    public function deleteGroupSharedFiles($group_id)
    {
        $files = $this->db->select('file_name')->where('group_id', $group_id)->get(db_prefix() . 'chatgroupsharedfiles')->result_array();

        if (!empty($files) && is_array($files)) {
            foreach ($files as $file) {
                if (is_dir(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER)) {
                    unlink(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER . '/' . $file['file_name']);
                }
            }
            $this->db->where('group_id', $group_id);
            $result = $this->db->delete(TABLE_CHATGROUPSHAREDFILES);
            if ($result) {
                return true;
            }
        } else {
            return false;
        }
        return false;
    }

    /**
     * Delete chat messages including pictures and files
     * @param mixed $id the staff id
     * @param mixed $contact_id the contact_id id
     * @return boolean
     */
    public function deleteMessage($id, $mixed_id)
    {
        $staff_id = get_staff_user_id();


        if (strpos($mixed_id, 'group_id') !== false) {
            $mixed_id = str_replace('group_id', '', $mixed_id);
            $possible_file = $this->db->select('message')->where('group_id', $mixed_id)->where('id', $id)->get(db_prefix() . 'chatgroupmessages')->row();

            if (prchat_checkMessageIfFileExists($possible_file->message)) {
                $file_name = getImageFullName($possible_file->message);


                if (is_dir(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER)) {
                    unlink(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER . '/' . $file_name);
                }
                $this->db->delete(db_prefix() . 'chatgroupsharedfiles', array('group_id' => $mixed_id, 'file_name' => $file_name));
            }

            $this->db->where('group_id', $mixed_id);
            $this->db->where('id', $id);
            $files_deleted = $this->db->update(db_prefix() . 'chatgroupmessages', [
                'is_deleted' => 1,
                'message' => ''
            ]);
            if ($files_deleted) {
                return true;
            }
        } else {
            $possible_file = $this->db->select()->where('id', $id)->get(db_prefix() . 'chatmessages')->row()->message;
            if (prchat_checkMessageIfFileExists($possible_file)) {
                $file_name = getImageFullName($possible_file);
                if (is_dir(PR_CHAT_MODULE_UPLOAD_FOLDER)) {
                    unlink(PR_CHAT_MODULE_UPLOAD_FOLDER . '/' . $file_name);
                }
                $this->db->delete(db_prefix() . 'chatsharedfiles', array('sender_id' => get_staff_user_id(), 'reciever_id' => $mixed_id, 'file_name' => $file_name));
                $this->db->delete(db_prefix() . 'chatsharedfiles', array('sender_id' => $mixed_id, 'reciever_id' => get_staff_user_id(), 'file_name' => $file_name));
            }

            $this->db->where('id', $id);
            $files_deleted = $this->db->update(db_prefix() . 'chatmessages', [
                'is_deleted' => 1,
                'message' => ''
            ]);
            if ($files_deleted) {
                return true;
            }
        }
        return false;
    }

    /**
     * Handles shared files between two users
     * @param mixed $own_id session id
     * @param mixed $id the contact shared files id
     * @return string
     */
    public function get_shared_files_and_create_template($own_id, $contact_id)
    {
        $files = [];
        $data_lity = ' ';
        $allFiles = "unknown|rar|zip|mp3|mp4|mov|flv|wmv|avi|doc|docx|pdf|xls|xlsx|zip|rar|txt|php|html|css|jpeg|jpg|png|swf|PNG|JPG|JPEG";
        $photoExtensions = "unknown|jpeg|jpg|png|gif|swf|PNG|JPG|JPEG|";
        $docFiles = "unknown|rar|zip|mp3|mp4|mov|flv|wmv|avi|doc|docx|pdf|xls|xlsx|zip|rar|txt|php|html|css";

        $dir = list_files(PR_CHAT_MODULE_UPLOAD_FOLDER);

        $from_messages_table = $this->db->query("SELECT file_name FROM " . db_prefix() . 'chatsharedfiles' . " WHERE file_name REGEXP '^.*\.(" . $allFiles . ")$' AND sender_id  = '" . $own_id . "' AND reciever_id = '" . $contact_id . "' OR sender_id = '" . $contact_id . "' AND reciever_id = '" . $own_id . "'");
        if ($from_messages_table) {
            $from_messages_table = $from_messages_table->result_array();
        } else {
            return false;
        }
        foreach ($dir as $file_name) {
            foreach ($from_messages_table as $value) {
                if (strpos($file_name, $value['file_name']) !== false) {
                    if (!in_array($file_name, $files)) {
                        array_push($files, $file_name);
                    }
                }
            }
        }

        $html = '';
        $html .= '<ul class="nav nav-tabs" role="tablist">';
        $html .= '<li class="active"><a href="#photos" role="tab" data-toggle="tab"><i class="fa fa-file-image-o icon_shared_files" aria-hidden="true"></i>' . _l('chat_photos_text') . '</a></li>';
        $html .= '<li><a href="#files" role="tab" data-toggle="tab"><i class="fa fa-file-o icon_shared_files" aria-hidden="true"></i>' . _l('chat_files_text') . '</a></li>';
        $html .= '</ul>';

        $html .= '<div class="tab-content">';
        $html .= '<div class="tab-pane active" id="photos">';
        $html .= '<span class="text-center shared_items_span">' . _l('chat_shared_photos_text') . '</span>';

        foreach ($files as $file) {
            if (preg_match("/^[^\?]+\.('" . $photoExtensions . "')$/", $file)) {
                $html .= "<a data-lity href='" . base_url('modules/prchat/uploads/' . $file) . "'>
               <div class='col-xs-3 shared_files_ahref' style='background-image:url(" . base_url('modules/prchat/uploads/' . $file) . ");'></div></a>";
            }
        }
        $html .= '</div>';
        $html .= '<div class="tab-pane" id="files">';
        $html .= '<span class="text-center shared_items_span">' . _l('chat_shared_files_text') . '</span>';

        foreach ($files as $file) {
            if (strpos($file, '.pdf')) {
                $data_lity = 'data-lity';
            }
            if (preg_match("/^[^\?]+\.('" . $docFiles . "')$/", $file)) {
                $html .= "<div class='col-md-12'><a target='_blank' " . $data_lity . " href ='" . base_url('modules/prchat/uploads/' . $file) . "'><i class='fa fa-file-o icon_shared_files' aria-hidden='true'></i>" . $file . "</a></div>";
            }
        }
        $html .= '</div></div>';
        return $html;
    }


    /**
     * Handles shared files between usersin group
     * @param mixed $group_id
     * @return string
     */
    public function get_group_shared_files_and_create_template($group_id)
    {
        $files = [];
        $data_lity = ' ';
        $allFiles = "unknown|rar|zip|mp3|mp4|mov|flv|wmv|avi|doc|docx|pdf|xls|xlsx|zip|rar|txt|php|html|css|jpeg|jpg|png|swf|PNG|JPG|JPEG";
        $photoExtensions = "unknown|jpeg|jpg|png|gif|swf|PNG|JPG|JPEG|";
        $docFiles = "unknown|rar|zip|mp3|mp4|mov|flv|wmv|avi|doc|docx|pdf|xls|xlsx|zip|rar|txt|php|html|css";

        $dir = list_files(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER);

        $from_messages_table = $this->db->query("SELECT file_name FROM " . db_prefix() . 'chatgroupsharedfiles' . " WHERE file_name REGEXP '^.*\.(" . $allFiles . ")$' AND group_id = '" . $group_id . "'");

        if ($from_messages_table) {
            $from_messages_table = $from_messages_table->result_array();
        } else {
            return false;
        }
        foreach ($dir as $file_name) {
            foreach ($from_messages_table as $value) {
                if (strpos($file_name, $value['file_name']) !== false) {
                    if (!in_array($file_name, $files)) {
                        array_push($files, $file_name);
                    }
                }
            }
        }

        $html = '';
        $html .= '<ul class="nav nav-tabs" role="tablist">';
        $html .= '<li class="active"><a href="#group_photos" role="tab" data-toggle="tab"><i class="fa fa-file-image-o icon_shared_files" aria-hidden="true"></i>' . _l('chat_photos_text') . '</a></li>';
        $html .= '<li><a href="#group_files" role="tab" data-toggle="tab"><i class="fa fa-file-o icon_shared_files" aria-hidden="true"></i>' . _l('chat_files_text') . '</a></li>';
        $html .= '</ul>';

        $html .= '<div class="tab-content">';
        $html .= '<div class="tab-pane active" id="group_photos">';
        $html .= '<span class="text-center shared_items_span">' . _l('chat_shared_photos_text') . '</span>';

        foreach ($files as $file) {
            if (preg_match("/^[^\?]+\.('" . $photoExtensions . "')$/", $file)) {
                $html .= "<a data-lity href='" . base_url('modules/prchat/uploads/groups/' . $file) . "'>
               <div class='col-md-3 shared_files_ahref' style='background-image:url(" . base_url('modules/prchat/uploads/groups/' . $file) . ");'></div></a>";
            }
        }
        $html .= '</div>';
        $html .= '<div class="tab-pane" id="group_files">';
        $html .= '<span class="text-center shared_items_span">' . _l('chat_shared_files_text') . '</span>';

        foreach ($files as $file) {
            if (strpos($file, '.pdf')) {
                $data_lity = 'data-lity';
            }
            if (preg_match("/^[^\?]+\.('" . $docFiles . "')$/", $file)) {
                $html .= "<div class='col-md-12'><a target='_blank' " . $data_lity . " href ='" . base_url('modules/prchat/uploads/groups/' . $file) . "'><i class='fa fa-file-o icon_shared_files' aria-hidden='true'></i>" . $file . "</a></div>";
            }
        }
        $html .= '</div></div>';

        return $html;
    }

    /**
     * [globalMessage Sends global message to selected members]
     * @param  [array] $members
     * @param  [string] $message
     * @param  [instance] $pusher
     * @return boolean
     */
    public function globalMessage($members, $message, $pusher)
    {
        if ($message == '') {
            return false;
        }
        if (empty($members)) {
            return false;
        }
        if (isset($members)) {
            if (is_array($members) && !empty($members)) {
                $message = _l('chat_message_announce') . $message;
                foreach ($members as $member_id) {
                    $message_data = array(
                        'sender_id' => get_staff_user_id(),
                        'reciever_id' => $member_id,
                        'message' => htmlspecialchars($message),
                        'viewed' => 0,
                    );

                    $this->chat_model->createMessage($message_data);
                    $pusher->trigger('presence-mychanel', 'send-event', array(
                        'message' => pr_chat_convertLinkImageToString($message, get_staff_user_id(), $member_id),
                        'from' => get_staff_user_id(),
                        'to' => $member_id,
                        'global' => true
                    ));
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Function that handldes new chat group creation
     * @param [array] $insertData
     * @param [array] $data
     * @param [instance] $pusher
     */
    public function addChatGroup($insertData, $data, $pusher)
    {
        $exists = $this->db->get_where(TABLE_CHATGROUPS, array('group_name' => $insertData['group_name']))->row('group_name');
        $own_id = $this->session->userdata('staff_user_id');

        $this->db->insert(TABLE_CHATGROUPS, $insertData);
        $insert_id = $this->db->insert_id();

        $presence_data = $data;

        foreach ($data['members'] as $member_id) {
            $this->db->insert(TABLE_CHATGROUPMEMBERS, ['group_name' => $data['group_name'], 'member_id' => $member_id, 'group_id' => $insert_id]);
        }

        $presence_data['group_id'] = $insert_id;
        $presence_data['result'] = 'success';
        $presence_data['created_by_id'] = $own_id;
        $presence_data['message'] = _l('chat_new_group_created_text');

        if ($pusher->trigger('group-chat', 'group-chat', $presence_data)) {
            echo json_encode(['data' => $presence_data]);
        } else {
            echo json_encode(['result' => 'error']);
        }
    }


    /**
     * Function that fetches all logged in user chat groups
     * @return json
     */
    public function getMyGroups()
    {
        $id = get_staff_user_id();

        $groups = $this->db->query('SELECT * from ' . TABLE_CHATGROUPS . ' ORDER BY id ASC')->result_array();

        $this->db->trans_start();

        foreach ($groups as $key => $group) {
            $groups[$key]['members'] = $this->db->query("SELECT member_id, firstname, lastname, group_id FROM " . TABLE_CHATGROUPMEMBERS . " JOIN " . TABLE_STAFF . " ON " . TABLE_STAFF . ".staffid=" . TABLE_CHATGROUPMEMBERS . ".member_id WHERE group_id=" . $group['id'] . " AND member_id=" . $id . "")->result_array();
        }

        if ($this->db->trans_complete()) {
            if (!empty($groups)) {
                echo json_encode(['groups' => $groups]);
            } else {
                echo json_encode(['noChannels' => true]);
            }
        }
    }


    /**
     * Function that is responsible when deleting a selected group
     * @param  [int] $group_id
     * @param  [string] $group_name
     * @param  [instance] $pusher
     * @return json
     */
    public function deleteGroup($group_id, $group_name, $pusher)
    {
        $group_members = $this->db->get(TABLE_CHATGROUPMEMBERS)->result_array();

        $this->db->trans_start();
        foreach ($group_members as $member) {
            if ($member['group_id'] == $group_id) {
                $this->db->where('group_id', $group_id);
                $this->db->delete(TABLE_CHATGROUPMEMBERS);

                $this->db->where('group_id', $group_id);
                $this->db->delete(TABLE_CHATGROUPMESSAGES);

                $this->chat_model->deleteGroupSharedFiles($group_id);
            }
        }


        if ($this->db->trans_complete()) {
            $this->db->where('id', $group_id);
            $this->db->delete(TABLE_CHATGROUPS);

            $presence_data = ['result' => 'true', 'group_name' => $group_name, 'group_id' => $group_id];
            $pusher->trigger($group_name, 'group-deleted', $presence_data);

            if ($this->db->affected_rows() !== 0) {
                echo json_encode(['result' => 'success']);
            } else {
                echo json_encode(['error' => 'nomore']);
            }
        } else {
            echo json_encode(['result' => 'failed']);
        }
    }


    /**
     * Function that handles when adding new members to chat groups
     * @param [string] $group_name
     * @param [int] $group_id
     * @param [array] $members
     * @param [instance] $pusher
     */
    public function addChatGroupMembers($group_name, $group_id, $members, $pusher)
    {
        $member_ids = [];

        foreach ($members as $member_id) {
            $this->db->where('group_name', $group_name);
            $this->db->where('group_id', $group_id);
            $this->db->insert(TABLE_CHATGROUPMEMBERS, ['group_name' => $group_name, 'member_id' => $member_id, 'group_id' => $group_id]);
            array_push($member_ids, $member_id);
        }

        $presence_data = [
            'group_name' => $group_name,
            'result' => 'success',
            'group_id' => $group_id,
            'user_ids' => $member_ids,
        ];

        if ($this->db->affected_rows() != 0) {
            if ($pusher->trigger('group-chat', 'added-to-channel', $presence_data)) {
                echo json_encode(['data' => $presence_data]);
            }
        } else {
            echo json_encode(['data' => 'failed']);
        }
    }


    /**
     * Function that fetches all chat group members
     * @return json
     */
    public function getGroupUsers($group_id)
    {
        $group_name = $this->db->get_where(TABLE_CHATGROUPS, ['id' => $group_id])->row('group_name');

        $this->db->select('member_id,  group_id, lastname, firstname, created_by_id');
        $this->db->from(TABLE_CHATGROUPMEMBERS);
        $this->db->where('group_id', $group_id);
        $this->db->join(TABLE_STAFF, '' . TABLE_STAFF . '.staffid=' . TABLE_CHATGROUPMEMBERS . '.member_id');
        $this->db->join(TABLE_CHATGROUPS, '' . TABLE_CHATGROUPS . '.id=' . TABLE_CHATGROUPMEMBERS . '.group_id');
        $query = $this->db->get();
        $groupUsers = $query->result_array();

        echo json_encode(['result' => 'success', 'users' => $groupUsers]);
    }

    /**
     * Function that fetches all members connected with specific group
     * @param  [int] $group_id
     * @return array
     */
    public function getCurrentGroupUsers($group_id)
    {
        $users = '';


        $group_id = $this->input->post('group_id');
        $this->db->select('member_id, lastname, firstname');
        $this->db->from(TABLE_CHATGROUPMEMBERS);
        $this->db->where('group_id', $group_id);
        $this->db->join(TABLE_STAFF, TABLE_STAFF . '.staffid=' . TABLE_CHATGROUPMEMBERS . '.member_id');
        $query = $this->db->get();
        $users = $query->result_array();

        if ($this->db->affected_rows() !== 0) {
            return $users;
        }
    }


    /**
     * Private function that checks if specific group is created by logged in user
     * @param  [int]  $group_id
     * @param  [int]  $user_id
     * @return boolean
     */
    private function isGroupCreatedBy($group_id, $user_id)
    {
        $result = $this->db->get_where(TABLE_CHATGROUPS, ['id' => $group_id, 'created_by_id' => $user_id])->row('created_by_id');

        if ($result !== null) {
            return $result;
        }
        return false;
    }


    /**
     * Function that removes user from specific group
     * @param  [string] $group_name
     * @param  [int] $group_id
     * @param  [int] $user_id
     * @param  [int] $own_id
     * @param  [instance] $pusher
     * @return json
     */
    public function removeChatGroupUser($group_name, $group_id, $user_id, $own_id, $pusher)
    {
        $groupCreatedBy = $this->isGroupCreatedBy($group_id, $user_id);

        // This means that an admin has removed the creator of the group and group is assigned to this admin automatically
        if ($groupCreatedBy !== $own_id) {
            $this->db->where('created_by_id', $user_id);
            $this->db->update(TABLE_CHATGROUPS, ['created_by_id' => $own_id]);
        }

        $this->db->where('group_id', $group_id);
        $this->db->where('group_name', $group_name);
        $this->db->where('member_id', $user_id);
        $query = $this->db->delete(TABLE_CHATGROUPMEMBERS);

        $presence_data['group_id'] = $group_id;
        $presence_data['group_name'] = $group_name;
        $presence_data['user_id'] = $user_id;

        if ($query) {
            $presence_data['created_by_me'] = $this->isGroupCreatedBy($group_id, $own_id);
            $pusher->trigger($group_name, 'removed-from-channel', $presence_data);
            echo json_encode(['response' => 'success', 'data' => $presence_data]);
        } else {
            echo json_encode(['response' => 'error']);
        }
    }


    /**
     * Function that handles when user leaves chat group
     * @param  [int] $group_id
     * @param  [int] $member_id
     * @param  [instance] $pusher
     * @return json
     */
    public function chatMemberLeaveGroup($group_id, $member_id, $pusher)
    {
        $userFullName = get_staff_full_name();

        $group_name = $this->db->get_where(TABLE_CHATGROUPS, ['id' => $group_id])->row('group_name');

        $this->db->where('group_id', $group_id);
        $this->db->where('member_id', $member_id);
        $deleted = $this->db->delete(TABLE_CHATGROUPMEMBERS);

        $presence_data = [
            'group_name' => $group_name,
            'group_id' => $group_id,
            'member_id' => $member_id,
            'user_full_name' => $userFullName
        ];

        if ($deleted) {
            $pusher->trigger('group-chat', 'member-left-channel', $presence_data);
            echo json_encode(['message' => 'deleted']);
        }
    }

    /**
     * Record clients and customer admins message into database
     * @param message_data (array)
     * @return boolean
     */
    public function recordClientMessage($message_data)
    {
        if ($this->db->insert(db_prefix() . 'chatclientmessages', $message_data)) {
            return true;
        }
        return false;
    }
}

/* End of file PRChat_model.php */
/* Location: ./modules/prchat/models/perfex_chat/Prchat_model.php */
