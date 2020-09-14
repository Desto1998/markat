<?php
if (get_option('pusher_chat_enabled') == '1' && is_client_logged_in()) {
    echo '<script src="https://js.pusher.com/5.0.1/pusher.min.js"></script>';
    echo '<script src="' . base_url('modules/prchat/assets/js/emoparser.js') . '"></script>';
    echo '<script src="' . base_url('modules/prchat/assets/js/lity.min.js') . '"></script>';

    $this->load->view('chat_clients_view');
}
