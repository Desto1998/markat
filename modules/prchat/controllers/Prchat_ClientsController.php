<?php
/*
Module Name: Perfex CRM Chat
Description: Chat Module for Perfex CRM
Author: Aleksandar Stojanov
Author URI: https://idevalex.com
Requires at least: 2.3.2
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Prchat_ClientsController extends ClientsController
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

    public function pusherCustomersAuth()
    {
        if ($this->input->get()) {
            $user_id      = 'client_' . get_contact_user_id(); // figure this out and it will work 
            $name         = get_contact_full_name(get_contact_user_id()); // figure this out and it will work 
            $channel_name = 'presence-clients';
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

                if ($this->session->has_userdata('prchat_client_before_login')) {
                    $this->session->unset_userdata('prchat_client_before_login');

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
    public function initClientChat()
    {
        if ($this->input->post()) {

            $from = $this->input->post('from');
            $receiver = $this->input->post('to');

            if ($this->input->post('typing') == 'false') {


                $message = $this->input->post('client_message');

                $message_data = array(
                    'sender_id'   => $from,
                    'reciever_id' => $receiver,
                    'message'     => htmlentities($message),
                    'viewed'      => 0,
                );

                $this->chat_model->recordClientMessage($message_data);

                $this->pusher->trigger(
                    'presence-clients',
                    'send-event',
                    array(
                        'message'        => pr_chat_convertLinkImageToString($message, $from, $receiver),
                        'from'           => $from,
                        'to'             => $receiver,
                        'client_image_path'   => contact_profile_image_url(str_replace('client_', '', $from)),
                        'from_name' => get_staff_full_name(str_replace('staff_', '', $from))
                    )
                );

                $this->pusher->trigger(
                    'presence-clients',
                    'notify-event',
                    array(
                        'from' => $from,
                        'to'   => $receiver,
                        'from_name'      => get_staff_full_name($from),
                    )
                );
            } elseif ($this->input->post('typing') == 'true') {

                $this->pusher->trigger(
                    'presence-clients',
                    'typing-event',
                    array(
                        'message' => $this->input->post('typing'),
                        'from' => $from,
                        'to' => $receiver
                    )
                );
            } else {
                $this->pusher->trigger(
                    'presence-clients',
                    'typing-event',
                    array(
                        'message' => 'null',
                        'from' => $from,
                        'to' => $receiver
                    )
                );
            }
        }
    }
    /**
     * Get logged in user messages sent to other user
     */
    public function getMutualMessages()
    {
        $limit   = $this->input->get('limit');
        $to    = $this->input->get('sender_id');
        $from      = $this->input->get('reciever_id');

        ($limit)
            ? $limit
            : $limit = 10;

        $offset  = 0;
        $message = '';

        if ($this->input->get('offset')) {
            $offset = $this->input->get('offset');
        }
        $response = $this->chat_model->getMutualMessages($from, $to, $limit, $offset);

        if ($response) {
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            header('Content-Type: application/json');
            $message = _l('chat_no_more_messages_in_database');
            echo json_encode($message);
        }
    }

    /**
     * Get unread messages, used when somebody sent a message while the user is offline
     */
    public function getClientUnreadMessages()
    {
        $result   = $this->chat_model->getClientUnreadMessages();

        if ($result) {
            header('Content-Type', 'application/json');
            echo json_encode($result);
        } else {
            echo json_encode(['null' => true]);
        }

        return false;
    }

    /**
     * Get unread messages, used when somebody sent a message while the user is offline
     */
    public function getStaffUnreadMessages()
    {
        $result   = $this->chat_model->getStaffUnreadMessages();

        if ($result) {
            header('Content-Type', 'application/json');
            echo json_encode($result);
        } else {
            echo json_encode(['null' => true]);
        }
        return false;
    }

    /**
     *  Uploads chat files
     */
    public function uploadMethod()
    {
        $allowedFiles = '*';
        $allowedFiles = str_replace(',', '|', $allowedFiles);
        $allowedFiles = str_replace('.', '', $allowedFiles);

        $config = array(
            'upload_path'   => PR_CHAT_MODULE_UPLOAD_FOLDER,
            'allowed_types' => $allowedFiles,
            'max_size'      => '9048000',
        );

        $this->load->library('upload', $config);

        if ($this->upload->do_upload()) {
            $from  = $this->input->post()['send_from'];
            $to    = str_replace('id_', '', $this->input->post()['send_to']);

            echo json_encode($data = array('upload_data' => $this->upload->data()));
        } else {
            echo json_encode($error = array('error' => $this->upload->display_errors()));
        }
    }


    /**
     * Update unread messages
     *
     * @return json
     */
    public function updateClientUnreadMessages()
    {
        $id = $this->input->post('id');
        $client = $this->input->post('client');
        echo json_encode($this->chat_model->updateClientUnreadMessages($id, isset($client) ? $client : null));
    }
}
