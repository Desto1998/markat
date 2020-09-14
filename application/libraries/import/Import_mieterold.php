<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/import/App_import.php');
require_once(APPPATH . 'libraries/excel/PHPExcel.php');
require_once(APPPATH . 'libraries/SimpleXLSX.php');

class Import_mieter extends App_import
{
    protected $notImportableFields = [];
    protected $requiredFields = ['firstname', 'lastname', 'email'];

    public function __construct()
    {
        /*      $this->notImportableFields = hooks()->apply_filters('not_importable_clients_fields', ['userid', 'id', 'is_primary', 'password', 'datecreated', 'last_ip', 'last_login', 'last_password_change', 'active', 'new_pass_key', 'new_pass_key_requested', 'leadid', 'default_currency', 'profile_image', 'default_language', 'direction', 'show_primary_contact', 'invoice_emails', 'estimate_emails', 'project_emails', 'task_emails', 'contract_emails', 'credit_note_emails', 'ticket_emails', 'addedfrom', 'registration_confirmed', 'last_active_time', 'email_verified_at', 'email_verification_key', 'email_verification_sent_at']);

              if (get_option('company_is_required') == 1) {
                  $this->requiredFields[] = 'company';
              }

              $this->addImportGuidelinesInfo('Duplicate email rows won\'t be imported.', true);

              $this->addImportGuidelinesInfo('Make sure you configure the default contact permission in <a href="' . admin_url('settings?group=clients') . '" target="_blank">Setup->Settings->Customers</a> to get the best results like auto assigning contact permissions and email notification settings based on the permission.');*/

        parent::__construct();
    }

    public function perform()
    {
        $this->initialize();
        $file = fopen($this->tmpFileStoragePath, 'r');
        $rows = array();
        //   while (($line = fgetcsv($file)) !== FALSE) {
        //$line is an array of the csv elements
        //    array_push($rows, $line);
        //  }
        // fclose($file);
        $rows = $this->getDetailData($this->tmpFileStoragePath);
        return $rows;
        // $rows =$this->formatcsv($rows);
        $databaseFields = $this->getImportableDatabaseFields();
        //    $this->ci->db->truncate(db_prefix() . 'mieters');
        $totalDatabaseFields = count($databaseFields);

        foreach ($rows as $rowNumber => $row) {
            $insert = [];
            if (empty($row['fullname']) && empty($row['vorname']) && empty($row['nachname']))
                continue;

            $insert['fullname'] = $row['vollstandiger-nam'] ? $row['vollstandiger-nam'] : '';
            $insert['vorname'] = $row['vorname'] ? $row['vorname'] : '';
            $insert['nachname'] = $row['nachname'] ? $row['nachname'] : '';
            // $insert['betreuer'] = $row['betreuer'];
            $insert['email'] = $row['email'] ? $row['email'] : '';
            $insert['userid'] = get_staff_user_id();
            $insert['strabe_m'] = $row['strabe'] ? $row['strabe'] : '';
            $insert['etage'] = $row['etage'] ? $row['etage'] : '';
            $insert['plz'] = $row['plz'] ? $row['plz'] : '';
            $insert['hausnummer_m'] = $row['hausnummer'] ? $row['hausnummer'] : '';
            $insert['stadt'] = $row['stadt'] ? $row['stadt'] : '';
            $insert['telefon_1'] = $row['telefon-1'] ? $row['telefon-1'] : '';
            $insert['telefon_2'] = $row['telefon-2'] ? $row['telefon-2'] : '';
            $insert['telefon_3'] = $row['telefon-3'] ? $row['telefon-3'] : '';
            $insert['strabe_p'] = $row['umsertzwohnung-strabe'] ? $row['umsertzwohnung-strabe'] : '';
            $insert['nr_p'] = $row['umsertzwohnung-nr'] ? $row['umsertzwohnung-nr'] : '';
            $insert['etage_p'] = $row['umsertzwohnung-etage'] ? $row['umsertzwohnung-etage'] : '';
            $insert['fulger_p'] = $row['umsertzwohnung-flugel'] ? $row['umsertzwohnung-flugel'] : '';
            $insert['hausnummer_a'] = $row['ausweichkeller-hausnummer'] ? $row['ausweichkeller-hausnummer'] : '';
            $insert['kellernummer_a	'] = $row['ausweichkeller-kellernummer'] ? $row['ausweichkeller-kellernummer'] : '';
            $insert['strabe_a'] = $row['ausweichkeller-strabe'] ? $row['ausweichkeller-strabe'] : '';
            $insert['baubeginn'] = $row['baubeginn'] ? $row['baubeginn'] : '';
            $insert['beraumung'] = $row['beraumung'] ? $row['beraumung'] : '';
            $insert['k_nummer'] = $row['keller-nummer'] ? $row['keller-nummer'] : '';
            $insert['nummer'] = $row['nummer'] ? $row['nummer'] : '';
            $insert['flugel'] = $row['flugel'] ? $row['flugel'] : '';
            $insert['ruckraumung'] = $row['ruckraumung'] ? $row['ruckraumung'] : '';
            $insert['bauende'] = $row['bauende'] ? $row['bauende'] : '';
            $insert['fenstereinbau'] = $row['art'] ? $row['art'] : '';
            $insert['fenstereinbau_d'] = $row['fenstereinbau-datum'] ? $row['fenstereinbau-datum'] : '';
            $insert['k_baubeginn'] = $row['baubeginn-keller'] ? $row['baubeginn-keller'] : '';
            $insert['k_ruckraumung'] = $row['ruckraumung-keller'] ? $row['ruckraumung-keller'] : '';
            $insert['umsetzwohnung'] = $row['umsetzwohnung'] ? $row['umsetzwohnung'] : '';
            $insert['haustiere'] = $row['raucher'] == 'Ja' ? 1 : 0;
            $insert['geschoss'] = $row['geschoss'] == 'Ja' ? 1 : 0;
            //   $insert['raucher'] = $row[''];
            $insert['active'] = 1;
            $insert['updated_at'] = date('Y-m-d H:i:s');
            $insert['created_at'] = date('Y-m-d H:i:s');

            $insert = $this->trimInsertValues($insert);
/*
            if (count($insert) > 0) {
                $id = null;

                $tags = '';
                $this->ci->db->insert(db_prefix() . 'mieters', $insert);
                $id = $this->ci->db->insert_id();
                if ($id > 0) {
                    $this->incrementImported();
                    handle_tags_save($tags, $id, 'mieter');
                }

            }*/

        }
    }


    function getDetailData_($file)
    {
        $excel = new PHPExcel();
        $file_type = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($file_type);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $header = true;
        if ($header) {
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $headingsArray = $headingsArray[1];
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);

         /*       if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;*/
                    foreach ($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$this->slugify($columnHeading)] = $dataRow[$row][$columnKey];
                    }
             /*   }*/
            }
        } else {
            //excel sheet with no header
            $namedDataArray = $objWorksheet->toArray(null, true, true, true);
        }

        var_dump($namedDataArray);
        var_dump($headingsArray);
        exit();
        return array("header" => $headingsArray, "values" => $namedDataArray);
    }


    function formatcsv($data = [])
    {
        $r = -1;
        for ($row = 1; $row <= count($data); ++$row) {
            if ((isset($data[$row])) && ($data[$row] > '')) {
                ++$r;
                foreach ($data[0] as $columnKey => $columnHeading) {
                    $namedDataArray[$r][$this->slugify($columnHeading)] = $data[$row][$columnKey];
                }
            }
        }
        return $namedDataArray;
    }

    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    protected function email_formatSampleData()
    {
        return uniqid() . '@example.com';
    }

    protected function failureRedirectURL()
    {
        return admin_url('mieter/import');
    }


    private function getContactFields()
    {
        return $this->ci->db->list_fields(db_prefix() . 'contacts');
    }

    private function isDuplicateContact($email)
    {
        return total_rows(db_prefix() . 'contacts', ['email' => $email]);
    }

}
