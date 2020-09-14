<?php
if (get_option('pusher_chat_enabled') == '1') {
	if (get_option('pusher_realtime_notifications')  ==  0) {
		echo '<script src="https://js.pusher.com/5.0.1/pusher.min.js"></script>';
	}
	if (!strpos(strtolower($_SERVER['REQUEST_URI']), 'chat_full_view') !== false) {
		$this->load->view('chat_toggled_view');
	}
}
