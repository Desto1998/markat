<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/import/App_import.php');

class Import_inventar extends App_import
{
    protected $notImportableFields = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function perform()
    {
        $this->initialize();
        $fn = fopen($this->tmpFileStoragePath, "r");
        while (!feof($fn)) {
            $result = fgets($fn);
            $result = trim($result);
            $this->incrementImported();
            $id = null;
            $tags = '';
            if (!$this->if_exist($result)) {
                $insert['name'] = $result;
                $this->ci->db->insert(db_prefix() . 'inventarliste', $insert);
                $id = $this->ci->db->insert_id();
                if ($id) {
                    handle_tags_save($tags, $id, 'inventarliste');
                }
            }


        }
        fclose($fn);
    }

    public function if_exist($name)
    {
        $this->ci->db->where('name', $name);
        return $this->ci->db->get(db_prefix() . 'inventarliste')->row();

    }

    protected function failureRedirectURL()
    {
        return admin_url('mieter/import');
    }


}
