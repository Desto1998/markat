<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Solutionbox extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('utilities_model');
        $this->load->model('staff_model');
    }


    // Moved here from version 1.0.5
    public function index()
    {
        $this->load->helper('url');
        $data['title']     = _l('media_files');
        $data['connector'] = admin_url() . '/utilities/media_connector';
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);

        $mediaLocale = get_media_locale();

        $this->app_scripts->add('media-js', 'assets/plugins/elFinder/js/elfinder.min.js');

        if (file_exists(FCPATH . 'assets/plugins/elFinder/js/i18n/elfinder.' . $mediaLocale . '.js') && $mediaLocale != 'en') {
            $this->app_scripts->add('media-lang-js', 'assets/plugins/elFinder/js/i18n/elfinder.' . $mediaLocale . '.js');
        }

        $this->load->view('admin/utilities/media', $data);
    }

    public function media_connector()
    {
        $media_folder = $this->app->get_media_folder();
        $mediaPath    = FCPATH . $media_folder;

        if (!is_dir($mediaPath)) {
            mkdir($mediaPath, 0755);
        }

        if (!file_exists($mediaPath . '/index.html')) {
            $fp = fopen($mediaPath . '/index.html', 'w');
            if ($fp) {
                fclose($fp);
            }
        }

        $this->load->helper('path');

        $root_options = [
            'driver' => 'LocalFileSystem',
            'path'   => set_realpath($media_folder),
            'URL'    => site_url($media_folder) . '/',
            //'debug'=>true,
            'uploadMaxSize' => get_option('media_max_file_size_upload') . 'M',
            'accessControl' => 'access_control_media',
            'uploadDeny'    => [
                'application/x-httpd-php',
                'application/php',
                'application/x-php',
                'text/php',
                'text/x-php',
                'application/x-httpd-php-source',
                'application/perl',
                'application/x-perl',
                'application/x-python',
                'application/python',
                'application/x-bytecode.python',
                'application/x-python-bytecode',
                'application/x-python-code',
                'wwwserver/shellcgi', // CGI
            ],
            'uploadAllow' => !$this->input->get('editor') ? [] : ['image', 'video'],
            'uploadOrder' => [
                'deny',
                'allow',
            ],
            'attributes' => [
                [
                    'pattern' => '/.tmb/',
                    'hidden'  => true,
                ],
                [
                    'pattern' => '/.quarantine/',
                    'hidden'  => true,
                ],
                [
                    'pattern' => '/public/',
                    'hidden'  => true,
                ],
            ],
        ];

        if (!is_admin()) {
            $this->db->select('media_path_slug,staffid,firstname,lastname')
            ->from(db_prefix() . 'staff')
            ->where('staffid', get_staff_user_id());
            $user = $this->db->get()->row();
            $path = set_realpath($media_folder . '/' . $user->media_path_slug);
            if (empty($user->media_path_slug)) {
                $this->db->where('staffid', $user->staffid);
                $slug = slug_it($user->firstname . ' ' . $user->lastname);
                $this->db->update(db_prefix() . 'staff', [
                    'media_path_slug' => $slug,
                ]);
                $user->media_path_slug = $slug;
                $path                  = set_realpath($media_folder . '/' . $user->media_path_slug);
            }
            if (!is_dir($path)) {
                mkdir($path, 0755);
            }
            if (!file_exists($path . '/index.html')) {
                $fp = fopen($path . '/index.html', 'w');
                if ($fp) {
                    fclose($fp);
                }
            }
            array_push($root_options['attributes'], [
                'pattern' => '/.(' . $user->media_path_slug . '+)/', // Prevent deleting/renaming folder
                'read'    => true,
                'write'   => true,
                'locked'  => true,
            ]);
            $root_options['path'] = $path;
            $root_options['URL']  = site_url($media_folder . '/' . $user->media_path_slug) . '/';
        }

        $publicRootPath      = $media_folder . '/public';
        $public_root         = $root_options;
        $public_root['path'] = set_realpath($publicRootPath);

        $public_root['URL'] = site_url($media_folder) . '/public';
        unset($public_root['attributes'][3]);

        if (!is_dir($publicRootPath)) {
            mkdir($publicRootPath, 0755);
        }

        if (!file_exists($publicRootPath . '/index.html')) {
            $fp = fopen($publicRootPath . '/index.html', 'w');
            if ($fp) {
                fclose($fp);
            }
        }

        $opts = [
            'roots' => [
                $root_options,
                $public_root,
            ],
        ];

        $opts      = hooks()->apply_filters('before_init_media', $opts);
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }

}
