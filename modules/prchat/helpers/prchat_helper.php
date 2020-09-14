<?php
/*
Module Name: Perfex CRM Chat
Description: Chat Module for Perfex CRM
Author: Aleksandar Stojanov
Author URI: https://idevalex.com
*/

defined('BASEPATH') or exit('No direct script access allowed');
define('CHAT_CURRENT_URI', strtolower($_SERVER['REQUEST_URI']));
define('VERSIONING', get_instance()->app_scripts->core_version());

hooks()->add_action('before_staff_login', 'prchat_set_session_variable_before_login_for_notification');
hooks()->add_action('app_admin_head', 'pr_chat_add_head_components');
hooks()->add_action('app_admin_footer', 'pr_chat_init_checkView');
hooks()->add_action('app_admin_footer', 'pr_chat_load_js');
hooks()->add_action('app_admin_head', 'pr_chat_add_js_before_admin_render');
hooks()->add_filter('migration_tables_to_replace_old_links', 'pr_chat_migration_tables_to_replace_old_links');
hooks()->add_action('staff_member_deleted', 'pr_chat_staff_member_data_transfer');


// Check if clients view is enabled in Setup->Settings->Chat Settings
if (isClientsEnabled()) {
    hooks()->add_action('before_client_login', 'prchat_set_session_variable_before_login_for_notification_client');
    hooks()->add_action('app_customers_head', 'handle_clients_css_styles');
    hooks()->add_action('app_customers_footer', 'pr_chat_init_checkViewClients');
}

/**
 * Function that handles css files for customers view
 *  
 * @return void
 */
function handle_clients_css_styles()
{
    echo '<link href="' . base_url('modules/prchat/assets/clients/styles.css' . '?v=' . VERSIONING . '') . '"  rel="stylesheet" type="text/css" >';
    echo '<link href="' . base_url('modules/prchat/assets/css/lity.css' . '?v=' . VERSIONING . '') . '"  rel="stylesheet" type="text/css" />';
}

/**
 * Check if can have permissions then apply new tab in settings
 */
if (staff_can('view', 'settings')) {
    hooks()->add_action('admin_init', 'prchat_add_settings_tab');
}

/**
 * [prchat_add_settings_tab net menu item in setup->settings]
 * @return void
 */
function prchat_add_settings_tab()
{
    $CI = &get_instance();
    $CI->app_tabs->add_settings_tab('prchat-settings', [
        'name'     => '' . _l('chat_settings_name') . '',
        'view'     => 'prchat/prchat_settings',
        'position' => 36,
    ]);
}

/**
 * [Set session variable before login > this is for html4 live notifications]
 * @return void
 */
function prchat_set_session_variable_before_login_for_notification()
{
    get_instance()->session->set_userdata('prchat_user_before_login', true);
}
/**
 * [Set session variable before login > this is for html4 live notifications]
 * @return void
 */
function prchat_set_session_variable_before_login_for_notification_client()
{
    get_instance()->session->set_userdata('prchat_client_before_login', true);
}

/**
 * [pr_chat_load_js inject javascript files]
 * @return void
 */
function pr_chat_load_js()
{
    if (!strpos($_SERVER['REQUEST_URI'], 'chat_full_view') !== false) {
        echo '<script src="' . module_dir_url('prchat', 'assets/js/pr-chat.js' . '?v=' . VERSIONING . '') . '"></script>';
    }
}

/**
 * Function that will inject the chat messages tables when user changing domain and need to replace old links.
 * @param  Array $tables
 * @return array
 */
function pr_chat_migration_tables_to_replace_old_links($tables)
{
    $tables[] = [
        'table' => db_prefix() . 'chatmessages',
        'field' => 'message',
    ];

    return $tables;
}

/**
 * Injects chat CSS
 * @return null
 */
function pr_chat_add_head_components()
{
    if (!strpos($_SERVER['REQUEST_URI'], 'chat_full_view') !== false) {
        echo '<link href="' . base_url('modules/prchat/assets/css/chat_styles.css' . '?v=' . VERSIONING . '') . '"  rel="stylesheet" type="text/css" >';
    } else {
        chat_check_theme_options();
    }
    echo '<link href="' . base_url('modules/prchat/assets/css/tooltipster.bundle.min.css') . '"  rel="stylesheet" type="text/css" >';
    echo '<link href="' . base_url('modules/prchat/assets/css/lity.css') . '"  rel="stylesheet" type="text/css" />';
}

/**
 * Inject chat JS plugins
 */
function pr_chat_add_js_before_admin_render()
{
    if (!strpos($_SERVER['REQUEST_URI'], 'chat_full_view') !== false) {
        echo '<script src="' . base_url('modules/prchat/assets/js/jscolor.js' . '?v=' . VERSIONING . '') . '"></script>';
    }
    echo '<script src="' . base_url('modules/prchat/assets/js/emoparser.js' . '?v=' . VERSIONING . '') . '"></script>';
}

/**
 * Theme options
 * @return load css file
 */
function chat_check_theme_options()
{
    if (get_chat_theme_option() == 'light' || get_chat_theme_option() == null) {
        echo '<link href="' . base_url('modules/prchat/assets/css/chat_full_view.css' . '?v=' . VERSIONING . '') . '"  rel="stylesheet" type="text/css" />';
    } else {
        echo '<link href="' . base_url('modules/prchat/assets/css/chat_full_dark_view.css' . '?v=' . VERSIONING . '') . '"  rel="stylesheet" type="text/css" />';
    }
    echo '<link href="' . base_url('modules/prchat/assets/css/lity.css' . '?v=' . VERSIONING . '') . '"  rel="stylesheet" type="text/css" />';
}

/**
 * Loads the chat view
 * @return null
 */
function pr_chat_init_checkView()
{
    $CI = &get_instance();
    $CI->load->model('prchat/prchat_model', 'chat_model');
    $unreadMessages   = $CI->chat_model->getUnread();

    echo '<script src="' . base_url('modules/prchat/assets/js/lity.min.js') . '"></script>';
    echo $CI->load->view('prchat/initViewCheck', ['unreadMessages' => $unreadMessages], true);
}

/**
 * Loads the chat view
 * @return null
 */
function pr_chat_init_checkViewClients()
{
    $CI = &get_instance();
    echo $CI->load->view('prchat/initViewCheckClients');
}
/*
    * Function that will convert links to iamges if meets the regex
 */
function pr_chat_convertLinkImageToString($string)

{

    $regexImg = '/(http|https)\:\/\/(([a-zA-Z]{1}[a-zA-Z]{1})|([a-zA-Z0-9][a-zA-Z0-9-_]{1,61}[a-zA-Z0-9]))+.(\/\S*)?(gif|jpg|jpeg|tiff|png|swf)(\/\S*)?/m';

    if (preg_match_all($regexImg, $string)) {
        $string = preg_replace($regexImg, '<a href="' . htmlspecialchars('$0') . '" data-lity><img class="prchat_convertedImage" src="' . htmlspecialchars('$0') . '"/></a>', $string);
    }

    return $string;
}

/**
 * Get chat color by user id
 * @param  mixed $id
 * @param  mixed $name
 * @return mixed
 */
function pr_get_chat_color($id, $name = '')
{
    $CI = &get_instance();

    if ($CI->db->field_exists('value', db_prefix() . 'chatsettings')) {
        return pr_get_chat_option($id, $name);
    } else {
        $CI->db->select('chat_color');
        $CI->db->where('user_id', $id);
    }
    $result = $CI->db->get(db_prefix() . 'chatsettings')->row();

    if (!$result) {
        return '';
    }

    return $result->chat_color;
}

/**
 * Get chat get chat color on subscribe
 * @param  mixed $id
 * @param  mixed $name
 * @return mixed
 */
function pr_get_chat_option($id, $name)
{
    $CI = &get_instance();
    $CI->db->select('value');
    $CI->db->where('name', $name);
    $CI->db->where('user_id', $id);

    $result = $CI->db->get(db_prefix() . 'chatsettings')->row();

    if (!$result) {
        return '';
    }

    return $result->value;
}

/**
 * Function that will check check if current message contains image
 * @param  string $string
 * @return string
 */
function prchat_checkMessageIfFileExists($message)
{
    $regexImg = '/(http|https)\:\/\/(([a-zA-Z]{1})|([a-zA-Z]{1}[a-zA-Z]{1})|([a-zA-Z]{1}[0-9]{1})|([0-9]{1}[a-zA-Z]{1})|([a-zA-Z0-9][a-zA-Z0-9-_]{1,61}[a-zA-Z0-9]))\.([a-zA-Z]{2,6}|[a-zA-Z0-9-]{2,30}\.[a-zA-Z]{2,3})+.(\/\S*)?(unknown|gif|jpg|jpeg|tiff|png|swf|rar|zip|mp3|mp4|mov|flv|wmv|avi|doc|docx|pdf|xls|xlsx|zip|rar|txt|php|html|css|jpeg|jpg|png|swf|PNG|JPG|JPEG)(\/\S*)?/m';
    if (preg_match_all($regexImg, $message)) {
        return true;
    } else {
        return false;
    }
}
/**
 * Check if message has any images or files links containing
 * @param  string $image
 * @return string
 */
function getImageFullName($file)
{
    $url_arr = explode('/', $file);
    $ct = count($url_arr);
    $name = $url_arr[$ct - 1];
    $name_div = explode('.', $name);
    $ct_dot = count($name_div);

    return $name;
}

/**
 * Theme options
 * @return string
 */
function get_chat_theme_option()
{
    get_instance()->db->where('user_id', get_staff_user_id());
    get_instance()->db->where('name', 'current_theme');
    return get_instance()->db->get(db_prefix() . 'chatsettings')->row('value');
}
/**
 * Function that will check chat URL images and will convert to link
 * @param  string $string
 * @return string
 */
function make_url_clickable_cb($matches)
{
    $ret = '';
    $url = $matches[2];
    if (empty($url)) {
        return $matches[0];
    }
    // removed trailing [.,;:] from URL
    if (in_array(substr($url, -1), [
        '.',
        ',',
        ';',
        ':',
    ]) === true) {
        $ret = substr($url, -1);
        $url = substr($url, 0, strlen($url) - 1);
    }

    $hrefDest = str_replace('https://', '//', $url);
    $hrefDest = str_replace('http://', '//', $url);

    return $matches[1] . "<a href=\"$hrefDest\" rel=\"nofollow\" data-lity target='_blank'>$url</a>" . $ret;
}

/**
 * Callback for clickable
 */
function make_web_ftp_clickable_cb($matches)
{
    $ret  = '';
    $dest = $matches[2];
    $dest = 'http://' . $dest;
    if (empty($dest)) {
        return $matches[0];
    }
    // removed trailing [,;:] from URL
    if (in_array(substr($dest, -1), [
        '.',
        ',',
        ';',
        ':',
    ]) === true) {
        $ret  = substr($dest, -1);
        $dest = substr($dest, 0, strlen($dest) - 1);
    }

    $hrefDest = str_replace('https://', '//', $dest);
    $hrefDest = str_replace('http://', '//', $dest);

    return $matches[1] . "<a href=\"$hrefDest\" rel=\"nofollow\" data-lity target='_blank'>$dest</a>" . $ret;
}

/**
 * Callback for clickable
 */
function make_email_clickable_cb($matches)
{
    $email = $matches[2] . '@' . $matches[3];

    return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}

/**
 * Check for links/emails/ftp in string to wrap in href
 * @param  string $ret
 * @return string      formatted string with href in any found
 */
function clickable($ret)
{
    $ret = ' ' . $ret;
    // in testing, using arrays here was found to be faster
    $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', 'make_url_clickable_cb', $ret);
    $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', 'make_web_ftp_clickable_cb', $ret);
    $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', 'make_email_clickable_cb', $ret);
    // this one is not in an array because we need it to run last, for cleanup of accidental links within links
    $ret = preg_replace('#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i', '$1$3</a>', $ret);
    $ret = trim($ret);

    return $ret;
}

function check_for_links_lity($ret)
{
    return clickable($ret);
}

/**
 * Function that handles member data upon member deletion
 * @param  [array] $data
 * @return boolean
 */
function pr_chat_staff_member_data_transfer($data)
{
    $deleted = $data['id'];
    $transfer_data_to = $data['transfer_data_to'];
    $CI = &get_instance();

    $CI->db->trans_start();

    $CI->db->where('member_id', $deleted);
    $CI->db->delete(TABLE_CHATGROUPMEMBERS);

    $CI->db->where('sender_id', $deleted);
    $CI->db->delete(TABLE_CHATGROUPMESSAGES);

    $CI->db->where('sender_id', $deleted);
    $CI->db->or_where('reciever_id', $deleted);
    $CI->db->delete(db_prefix() . 'chatmessages');

    $CI->db->where('user_id', $deleted);
    $CI->db->delete(db_prefix() . 'chatsettings');

    $CI->db->where('created_by_id', $deleted);
    $CI->db->update(TABLE_CHATGROUPS, ['created_by_id' => $transfer_data_to]);

    $group_files = $CI->db->select('file_name')->where('sender_id', $deleted)->get(db_prefix() . 'chatgroupsharedfiles')->result_array();
    $files = $CI->db->select('file_name')->where('sender_id', $deleted)->get(db_prefix() . 'chatsharedfiles')->result_array();

    foreach ($group_files as $group_file) {
        if (is_dir(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER)) {
            unlink(PR_CHAT_MODULE_GROUPS_UPLOAD_FOLDER . '/' . $group_file['file_name']);
        }
    }

    foreach ($files as $file) {
        if (is_dir(PR_CHAT_MODULE_UPLOAD_FOLDER)) {
            unlink(PR_CHAT_MODULE_UPLOAD_FOLDER . '/' . $file['file_name']);
        }
    }

    $CI->db->where('sender_id', $deleted);
    $CI->db->delete(TABLE_CHATGROUPSHAREDFILES);

    $CI->db->where('sender_id', $deleted);
    $CI->db->delete(db_prefix() . 'chatsharedfiles');

    if ($CI->db->trans_complete()) {
        return true;
    }
    return false;
}


// Helpers for gradient colors
function validateChatColorBeforeApply($color, $model_check = '')
{
    $validColor = '';
    if (
        colorStartsWith($color, '#') && !colorEndsWith($color, ';')
        || colorStartsWith($color, 'linear-gradient(') && colorEndsWith($color, ');')
    ) {
        $validColor = $color;
    } else {
        $validColor = '#546bf1';
    }
    if ($model_check == true && $validColor === '#546bf1') {
        return 'unknownColor';
    }
    return $validColor;
}

// Helpers for gradient colors
function colorStartsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

// Helpers for gradient colors
function colorEndsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}


// Clients 
function get_staff_customers()
{
    $CI = &get_instance();

    $staffCanViewAllClients = staff_can('view', 'customers');

    $CI->db->select('firstname, lastname, ' . db_prefix() . 'contacts.id as contact_id, ' . get_sql_select_client_company());
    $CI->db->where(db_prefix() . 'clients.active', '1'); // get only active clients
    $CI->db->join('clients', db_prefix() . 'clients.userid=' . db_prefix() . 'contacts.userid', 'left');
    $CI->db->select(db_prefix() . 'clients.userid as client_id');

    if (!$staffCanViewAllClients) {
        $CI->db->where('(' . db_prefix() . 'clients.userid IN (SELECT customer_id FROM ' . db_prefix() . 'customer_admins WHERE staff_id=' . get_staff_user_id() . '))');
    }

    $result = $CI->db->get('contacts')->result_array();

    if ($CI->db->affected_rows() !== 0) {
        echo json_encode(['customers' => $result]);
    } else {
        echo json_encode(array('customers' => []));
    }
}

// Get current logged in contact its assigned customer admins
function get_customer_admins()
{
    $CI = &get_instance();

    $select = 'SELECT firstname, lastname, staffid, email, profile_image FROM ' . db_prefix() . 'staff';
    $where = 'WHERE (staffid IN (SELECT staff_id from ' . db_prefix() . 'customer_admins WHERE customer_id =' . get_client_user_id() . ')';

    $customer_admins = $CI->db->query('' . $select . ' ' . $where . '  OR admin=1) AND active=1')->result_array();

    echo json_encode($customer_admins);
}

function isClientsEnabled()
{
    return get_option('chat_client_enabled');
}
