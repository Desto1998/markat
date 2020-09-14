<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Driver_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get driver/s
     * @param mixed $id driver id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'driver.id', $id);
            return $this->db->get(db_prefix() . 'driver')->row();
        } else {
            return $this->db->get(db_prefix() . 'driver')->result_array();
        }
    }


    public function get_drivers($where = [])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'driver')->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new driver
     */
    public function add($data)
    {
        if ($data) {
 
            $this->db->insert(db_prefix() . 'driver', $data);
            $insert_id = $this->db->insert_id();

            hooks()->do_action('after_driver_added', $insert_id);
            log_activity('New driver Added [' . $data['driver_id'] . ']');

            return $insert_id;
        }

        return false;
    }

    /**
     * @param integer ID
     * @param integer Status ID
     * @return boolean
     * Update client status Active/Inactive
     */
    public function change_driver_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'driver', [
            'active' => $status,
        ]);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('client_status_changed', [
                'id' => $id,
                'status' => $status,
            ]);

            log_activity('Customer Status Changed [ID: ' . $id . ' Status(Active/Inactive): ' . $status . ']');

            return true;
        }

        return false;
    }

    /**
     * @param array $_POST data
     * @param integer Contract ID
     * @return boolean
     */
    public
    function update($data, $id)
    {
        $affectedRows = 0;



        /*  $data['belegt'] = $data['belegt'] == '1' ? 1 : 0;
          $data['tierhaltung'] = $data['tierhaltung'] == '1' ? 1 : 0;
          $data['mobiliert'] = $data['mobiliert'] == '1' ? 1 : 0;*/
        /*$date = str_replace('.', '-', $data['belegt_b']);
        $data['belegt_b'] = date("Y-m-d", strtotime($date));
        $date = str_replace('.', '-', $data['belegt_v']);
        $data['belegt_v'] = date("Y-m-d", strtotime($date));*/
        // $data['active'] = 1;

        $data = hooks()->apply_filters('before_driver_updated', $data, $id);


        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'driver', $data);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('after_driver_updated', $id);
            log_activity('Wohnungen Updated [' . $data['id'] . ']');

            return true;
        }

        return $affectedRows > 0;
    }

    public
    function delete($id)
    {
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'driver');
            return true;

    }

}
