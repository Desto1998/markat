<?php
/*
Module Name: Perfex CRM Chat
Description: Chat Module for Perfex CRM
Author: Aleksandar Stojanov
Author URI: https://idevalex.com
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Prchat_Controller extends AdminController
{
    /**
     * Stores the pusher options
     * @var array
     */
    protected $pusher_options = array();
    protected $pusher;

    /**
     * Controler __construct function to initialize options
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('prchat_model', 'chat_model');

        $this->pusher_options['app_key']    = get_option('pusher_app_key');
        $this->pusher_options['app_secret'] = get_option('pusher_app_secret');
        $this->pusher_options['app_id']     = get_option('pusher_app_id');


        if ($this->pusher_options['app_key'] == '' || $this->pusher_options['app_secret'] == '' || $this->pusher_options['app_id'] == '') {
            echo '<h1>Seems that your Pusher account it is not setup correctly.</h1>';
          //  echo '<h4>Setup Pusher now: <a href="' . site_url('admin/settings?group=pusher') . '">CRM Settings->Pusher.com</a></h4>';
          //  echo '<h4>Tutorial: <a target="blank" href="https://help.perfexcrm.com/setup-realtime-notifications-with-pusher-com/">See example how to setup Pusher from Perfex CRM documentation</a>';
            die;
        }

        if (!isset($this->pusher_options['cluster']) && get_option('pusher_cluster') != '') {
            $this->pusher_options['cluster'] = get_option('pusher_cluster');
        }
        $this->pusher = new Pusher\Pusher(
            $this->pusher_options['app_key'],
            $this->pusher_options['app_secret'],
            $this->pusher_options['app_id'],
            array('cluster' => $this->pusher_options['cluster'])
        );
    }

    /**
     *  Initialize Pusher
     */
    public function initiateChat()
    {
        if ($this->input->post()) {
            if ($this->input->post('typing') == 'false') {
                $imageData['sender_image']   = $this->chat_model->getUserImage(get_staff_user_id());
                $imageData['receiver_image'] = $this->chat_model->getUserImage(str_replace('#', '', $this->input->post('to')));

                $from = $this->input->post('from');
                $receiver = str_replace('#', '', $this->input->post('to'));

                $message_data = array(
                    'sender_id'   => $this->input->post('from'),
                    'reciever_id' => str_replace('#', '', $this->input->post('to')),
                    'message'     => htmlentities($this->input->post('msg')),
                    'viewed'      => 0,
                );

                $last_id = $this->chat_model->createMessage($message_data);

                $this->pusher->trigger('presence-mychanel', 'send-event', array(
                    'message'        => pr_chat_convertLinkImageToString($this->input->post('msg'), $from, $receiver),
                    'from'           => $from,
                    'to'             => $receiver,
                    'last_insert_id' => $last_id,
                    'sender_image'   => $imageData['sender_image'],
                    'receiver_image' => $imageData['receiver_image'],
                ));

                $this->pusher->trigger(
                    'presence-mychanel',
                    'notify-event',
                    array(
                        'from' => $this->input->post('from'),
                        'to'   => str_replace('#', '', $this->input->post('to')),
                        'from_name'      => get_staff_full_name($from),
                        'sender_image'   => $imageData['sender_image'],
                        'message'        => pr_chat_convertLinkImageToString($this->input->post('msg'), $from, $receiver),
                    )
                );
            } elseif ($this->input->post('typing') == 'true') {
                $this->pusher->trigger(
                    'presence-mychanel',
                    'typing-event',
                    array(
                        'message' => $this->input->post('typing'),
                        'from' => $this->input->post('from'),
                        'to' => str_replace('#', '', $this->input->post('to'))
                    )
                );
            } else {
                $this->pusher->trigger(
                    'presence-mychanel',
                    'typing-event',
                    array(
                        'message' => 'null',
                        'from' => $this->input->post('from'),
                        'to' => str_replace('#', '', $this->input->post('to'))
                    )
                );
            }
        }
    }


    /**
     *  Main event when sendiing messages
     */
    public function initiateGroupChat()
    {
        if ($this->input->post()) {
            $from = $this->input->post('from');
            $group_id = $this->input->post('group_id');
            $group_name = $this->db->get_where(TABLE_CHATGROUPS, ['id' => $group_id])->row('group_name');

            if ($this->input->post('typing') == 'false') {
                $imageData['sender_image']   = $this->chat_model->getUserImage(get_staff_user_id());

                $message_data = array(
                    'sender_id'   => $this->input->post('from'),
                    'group_id' => $this->input->post('group_id'),
                    'message'     => htmlspecialchars($this->input->post('g_message')),
                    'is_deleted'      => 0,
                );

                $last_id = $this->chat_model->createGroupMessage($message_data);
                $last_id = 1;

                $this->pusher->trigger($group_name, 'group-send-event', array(
                    'message'        => pr_chat_convertLinkImageToString($this->input->post('g_message')),
                    'from'           => $from,
                    'to_group'   => $group_id,
                    'from_name' => get_staff_full_name($this->input->post('from')),
                    'group_name'   => $group_name,
                    'last_insert_id' => $last_id,
                    'sender_image'   => $imageData['sender_image']
                ));

                $this->pusher->trigger($group_name, 'group-notify-event', array(
                    'from' => $this->input->post('from'),
                    'from_name' => get_staff_full_name($this->input->post('from')),
                    'to_group'   => $group_id,
                    'group_name'   => $group_name,
                    'sender_image'   => $imageData['sender_image'],
                    'message'        => pr_chat_convertLinkImageToString($this->input->post('g_message')),
                ));
            } elseif ($this->input->post('typing') == 'true') {
                $this->pusher->trigger(
                    $group_name,
                    'group-typing-event',
                    array(
                        'message' => $this->input->post('typing'),
                        'from' => $this->input->post('from'),
                        'to_group' => $group_id,
                        'group_name' => $group_name
                    )
                );
            } else {
                $this->pusher->trigger(
                    $group_name,
                    'group-typing-event',
                    array(
                        'message' => 'test',
                        'from' => $this->input->post('from'),
                        'to_group' => $group_id,
                        'group_name' => $group_name
                    )
                );
            }
        }
    }

    /**
     * Get staff members for chat
     */
    public function users()
    {
        $users = $this->chat_model->getUsers();
        if ($users) {
            echo json_encode($users, true);
        } else {
            die(_l('chat_error_table'));
        }
    }

    /**
     * Get pusher key
     */
    public function getKey()
    {
        if (isset($this->pusher_options['app_key']) && !empty($this->pusher_options['app_key'])) {
            echo json_encode($this->pusher_options['app_key']);
        } else {
            die(_l('chat_app_key_not_found'));
        }
    }

    /**
     * Get staff that will be used for the chat window
     */
    public function getStaffInfo()
    {
        if ($this->input->post('id')) {
            $id       = $this->input->post('id');
            $response = $this->chat_model->getStaffInfo($id);

            if ($response) {
                echo json_encode($response);
            }
        }
        return false;
    }

    /**
     * Get logged in user messages sent to other user
     */
    public function getMessages()
    {
        $limit   = $this->input->get('limit');
        $from    = $this->input->get('from');
        $to      = $this->input->get('to');

        ($limit)
            ? $limit
            : $limit = 10;

        $offset  = 0;
        $message = '';

        if ($this->input->get('offset')) {
            $offset = $this->input->get('offset');
        }

        $response = $this->chat_model->getMessages($from, $to, $limit, $offset);

        if ($response) {
            echo json_encode($response);
        } else {
            $message = _l('chat_no_more_messages_in_database');
            echo json_encode($message);
        }
    }

    /**
     * Get group messages
     */
    public function getGroupMessages()
    {
        $limit     = $this->input->get('limit');
        $group_id  = $this->input->get('group_id');
        $message = '';

        ($limit)
            ? $limit
            : $limit = 10;

        $offset  = 0;


        if ($this->input->get('offset')) {
            $offset = $this->input->get('offset');
        }

        $response = $this->chat_model->getGroupMessages($group_id, $limit, $offset);

        if ($response) {
            echo json_encode($response);
        } else {
            $message = _l('chat_no_more_messages_in_database');
            echo json_encode($message);
        }
    }

    /**
     * Get group messages history
     */
    public function getGroupMessagesHistory()
    {
        $limit     = $this->input->get('limit');
        $group_id  = $this->input->get('group_id');

        ($limit)
            ? $limit
            : $limit = 10;

        $offset  = 0;
        $message = '';

        if ($this->input->get('offset')) {
            $offset = $this->input->get('offset');
        }

        $response = $this->chat_model->getGroupMessagesHistory($group_id, $limit, $offset);

        if ($response) {
            echo json_encode($response);
        } else {
            $message = _l('chat_no_more_messages_in_database');
            echo json_encode($message);
        }
    }

    /**
     * Get unread messages, used when somebody sent a message while the user is offline
     */
    public function getUnread($return = false)
    {
        $result   = $this->chat_model->getUnread();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['success' => false]);
        }

        return false;
    }

    /**
     * Updated unread messages to read
     */
    public function updateUnread()
    {
        if ($this->input->post('id')) {
            $id       = $this->input->post('id');
            $response = array();
            $result   = $this->chat_model->updateUnread($id);

            if ($result) {
                echo json_encode($result);
            } else {
                echo json_encode($response['success'] = false);
            }
        }
    }

    /**
     * Pusher authentication
     */
    public function pusher_auth()
    {
        if ($this->input->get()) {
            $name         = get_staff_full_name();
            $user_id      = get_staff_user_id();
            $channel_name = $this->input->get('channel_name');
            $socket_id    = $this->input->get('socket_id');

            if (!$channel_name) {
                exit('channel_name must be supplied');
            }

            if (!$socket_id) {
                exit('socket_id must be supplied');
            }

            if (
                !empty($this->pusher_options['app_key'])
                && !empty($this->pusher_options['app_secret'])
                && !empty($this->pusher_options['app_id'])
            ) {
                $justLoggedIn = false;

                if ($this->session->has_userdata('prchat_user_before_login')) {
                    $this->session->unset_userdata('prchat_user_before_login');

                    $justLoggedIn = true;
                }

                $presence_data = array('name' => $name, 'justLoggedIn' => $justLoggedIn);

                $auth          = $this->pusher->presence_auth($channel_name, $socket_id, $user_id, $presence_data);
                $callback      = str_replace('\\', '', $this->input->get('callback'));
                header('Content-Type: application/javascript');
                echo ($callback . '(' . $auth . ');');
            } else {
                exit('Appkey, secret or appid is missing');
            }
        }
    }

    /**
     *  Uploads chat files
     */
    public function uploadMethod()
    {
        $allowedFiles = get_option('allowed_files');
        $allowedFiles = str_replace(',', '|', $allowedFiles);
        $allowedFiles = str_replace('.', '', $allowedFiles);

        $config = array(
            'upload_path'   => PR_CHAT_MODULE_UPLOAD_FOLDER,
            'allowed_types' => $allowedFiles,
            'max_size'      => '9048000',
            // 'max_height'    => '961',
            // 'max_width'     => '1281',
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload()) {
            $from  = $this->input->post()['send_from'];
            $to    = str_replace('id_', '', $this->input->post()['send_to']);

            if (is_numeric($from) && is_numeric($to)) {
                $this->db->insert(
                    'tblchatsharedfiles',
                    [
                        'sender_id' => $from,
                        'reciever_id' => $to,
                        'file_name' => $this->upload->data('file_name')
                    ]
                );
            }

            echo json_encode($data = array('upload_data' => $this->upload->data()));
        } else {
            echo json_encode($error = array('error' => $this->upload->display_errors()));
        }
    }

    /**
     *  Uploads chat group files
     */
    public function groupUploadMethod()
    {
        $allowedFiles = get_option('allowed_files');
        $allowedFiles = str_replace(',', '|', $allowedFiles);
        $allowedFiles = str_replace('.', '', $allowedFiles);

        $config = array(
            'upload_path'   => PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER,
            'allowed_types' => $allowedFiles,
            'max_size'      => '9048000',
            // 'max_height'    => '961',
            // 'max_width'     => '1281',
        );

        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
            $from  = $this->input->post()['send_from'];
            $to_group    = $this->input->post()['to_group'];

            $this->db->insert(
                'tblchatgroupsharedfiles',
                [
                    'sender_id' => $from,
                    'group_id' => $to_group,
                    'file_name' => $this->upload->data('file_name')
                ]
            );

            echo json_encode($data = array('upload_data' => $this->upload->data()));
        } else {
            echo json_encode($error = array('error' => $this->upload->display_errors()));
        }
    }

    /**
     * Resets toggled chat theme colors
     */
    function resetChatColors()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        $user_id = get_staff_user_id();
        echo json_encode($this->chat_model->resetChatColors($user_id));
    }
    /**
     * Handles chat color change request
     */
    public function colorchange()
    {
        $id = get_staff_user_id();
        $color              = trim($this->input->post('color'));

        if ($this->input->post('get_chat_color')) {
            echo json_encode(pr_get_chat_color($id));
        }

        if ($this->input->post('color')) {
            echo json_encode($this->chat_model->setChatColor($color));
        }
    }
    /**
     * Deletes user own messages
     */
    public function deleteMessage()
    {
        $id = $this->input->post('id');
        $contact_id = $this->input->post('contact_id');

        if ($this->input->post('group_id')) {
            $group_id = $this->input->post('group_id');

            echo json_encode($this->chat_model->deleteMessage($id, 'group_id' . $group_id));
        } else {
            echo json_encode($this->chat_model->deleteMessage($id, $contact_id));
        }
    }

    /**
     * Switch user theme light or dark
     */
    public function switchTheme()
    {
        $id = get_staff_user_id();
        $theme_name = $this->input->post('theme_name');

        echo json_encode($this->chat_model->updateChatTheme($id, $theme_name));
    }

    /**
     * Loads user full chat browser view
     */
    public function chat_full_view()
    {

        $result   = $this->chat_model->getUnread();
        $this->load->view('prchat/chat_full_view', ['unreadMessages' => $result]);
    }

    /**
     * Handles shared files between two users
     */
    public function getSharedFiles()
    {
        if ($this->input->post()) {
            $own_id = $this->input->post('own_id');
            $contact_id = $this->input->post('contact_id');

            $html = $this->chat_model->get_shared_files_and_create_template($own_id, $contact_id);

            if ($html) {
                echo json_encode($html);
            }
        }
    }

    /**
     * Handles shared files between users in group
     */
    public function getGroupSharedFiles()
    {
        if ($this->input->post()) {
            $group_id = $this->input->post('group_id');

            $html = $this->chat_model->get_group_shared_files_and_create_template($group_id);

            if ($html) {
                echo json_encode($html);
            }
        }
    }

    /**
     *  Handles staff announcement modal view
     * @return modal view
     */
    public function staff_announcement()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        $data['title'] = 'Chat announcements';
        $data['staff'] = $this->chat_model->getUsers();

        $this->load->view('prchat/includes/modal', $data);
    }

    /**
     * Handles data inserting for global message to selected members
     * @return json / true ? false
     */
    public function staff_get_selected_members()
    {
        if ($this->input->post()) {
            $members = $this->input->post('members');
            $message = $this->input->post('message');

            echo json_encode($this->chat_model->globalMessage($members, $message, $this->pusher));
        }
    }
    public function chatGroups()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        $data['title'] = _l('chat_group_modal_title');
        $data['staff'] = $this->chat_model->getUsers();

        $this->load->view('prchat/includes/groups_modal', $data);
    }


    /**
     * Loads new modal for creating new chat group
     */
    public function addNewChatGroupMembersModal()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        $data['title'] = _l('chat_group_modal_add_title');
        $users = $this->chat_model->getUsers();
        $data['staff'] = [];
        $group_id = $this->input->get('group_id');
        $currentUsers = $this->getCurrentGroupUsers($group_id);

        foreach ($users as $selector => $staff) {
            foreach ($currentUsers as $currentUser) {
                if ($currentUser['member_id'] == $staff['staffid']) {
                    unset($users[$selector]);
                }
            }
        }

        $data['staff'] = $users;

        $this->load->view('prchat/includes/add_modal', $data);
    }

    /**
     * Adds new chat members to specific group
     */
    public function addChatGroupMembers()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        if ($this->input->post('group_name')) {
            $group_name = $this->input->post('group_name');
            $members = $this->input->post('members');
            $group_id = $this->input->post('group_id');

            return $this->chat_model->addChatGroupMembers($group_name, $group_id, $members, $this->pusher);
        }
    }

    /**
     * Function that creates new chat group
     */
    public function addChatGroup()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        if ($this->input->post('group_name')) {
            $data = [];

            $data['group_name'] = 'presence-' . $this->input->post('group_name');

            $data['members'] = $this->input->post('members');

            $own_id = $this->session->userdata('staff_user_id');

            if (empty($data['members'])) {
                return false;
            }

            if (!in_array($own_id, $data['members'])) {
                array_push($data['members'], $own_id);
            }

            $insertData = [
                'created_by_id' => $own_id,
                'group_name' => $data['group_name'],
            ];

            return $this->chat_model->addChatGroup($insertData, $data, $this->pusher);
        }
    }

    /**
     * Function that fetches all groups linked to current logged in user
     */
    public function getMyGroups()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        return $this->chat_model->getMyGroups();
    }


    /**
     * Function that handles chat group deletion
     */
    public function deleteGroup()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        if ($this->input->post('group_id')) {
            $group_id = $this->input->post('group_id');
            $group_name = $this->input->post('group_name');

            return $this->chat_model->deleteGroup($group_id, $group_name, $this->pusher);
        }
    }

    /**
     * Function that fetches all group members
     */
    public function getGroupUsers()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        if ($this->input->post('group_id') !== '') {
            $group_id = $this->input->post('group_id');
            return $this->chat_model->getGroupUsers($group_id);
        }
    }

    /**
     * Secondary Function that fetches all group members
     */
    public function getCurrentGroupUsers()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        if ($this->input->post('group_id') !== '') {
            $group_id = $this->input->post('group_id');
            $users = $this->chat_model->getCurrentGroupUsers($group_id);
            if (is_array($users) && !empty($users)) {
                return $users;
            } else {
                return false;
            }
        }
    }


    /**
     * Function that handles chat group member removal
     */
    public function removeChatGroupUser()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        $own_id = get_staff_user_id();

        if ($this->input->post('id')) {
            $group_name = $this->input->post('group_name');
            $user_id = $this->input->post('id');
            $group_id = $this->input->post('group_id');

            return $this->chat_model->removeChatGroupUser($group_name, $group_id, $user_id, $own_id, $this->pusher);
        } else {
            return false;
        }
    }

    /**
     * Function that is responsible for when chat members leaves group
     */
    public function chatMemberLeaveGroup()
    {
        if (!$this->input->is_ajax_request()) {
            redirect('admin/prchat/Prchat_Controller/chat_full_view', 'refresh');
        }

        if ($this->input->post('group_id')) {
            $group_id = $this->input->post('group_id');
            $member_id = $this->input->post('member_id');
            return $this->chat_model->chatMemberLeaveGroup($group_id, $member_id, $this->pusher);
        }
    }
}
