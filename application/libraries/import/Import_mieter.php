<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/import/App_import.php');
require_once(APPPATH . 'libraries/SimpleXLSX.php');

class Import_mieter extends App_import
{
    protected $notImportableFields = [];
    protected $requiredFields = ['firstname', 'lastname', 'email'];

    public function __construct()
    {
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
        if ($xlsx = SimpleXLSX::parse($this->tmpFileStoragePath)) {

            // Produce array keys from the array values of 1st array element
            $header_values = $rows = [];
            foreach ($xlsx->rows() as $k => $r) {
                if ($k === 0) {
                    $header_values = array_map('nestedLowercase', $r);
                    continue;
                }
                $rows[] = array_combine($header_values, $r);
            }
            return array("header" => $header_values, "values" => $rows);
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
                    $namedDataArray[$r][slugify($columnHeading)] = $dataRow[$row][$columnKey];
                }
                /*   }*/
            }
        } else {
            //excel sheet with no header
            $namedDataArray = $objWorksheet->toArray(null, true, true, true);
        }

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
