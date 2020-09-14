<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lieferanten_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get lieferanten/s
     * @param mixed $id lieferanten id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'lieferanten.id', $id);
            return $this->db->get(db_prefix() . 'lieferanten')->row();
        } else {
            return $this->db->get(db_prefix() . 'lieferanten')->result_array();
        }
    }

    public function get_by_userid($userid)
    {
        $this->db->where('userid', $userid);
        return $this->db->get(db_prefix() . 'lieferanten')->row();
    }


    public function get_lieferantens($where = [])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'lieferanten')->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new lieferanten
     */
    public function add($data)
    {
        if ($data) {

            if (isset($data['austattung'])) {
                $data['austattung'] = serialize($data['austattung']);
            }

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            /*    $data['belegt'] = $data['belegt'] == '1' ? 1 : 0;-
                $data['tierhaltung'] = $data['tierhaltung'] == '1' ? 1 : 0;
                $data['mobiliert'] = $data['mobiliert'] == '1' ? 1 : 0;*/

            /*  $date = str_replace('.', '-', $data['belegt_b']);
              $data['belegt_b'] = date("Y-m-d", strtotime($date));
              $date = str_replace('.', '-', $data['belegt_v']);
              $data['belegt_v'] = date("Y-m-d", strtotime($date));*/

            $data['userid'] = get_staff_user_id();
            $data['active'] = 1;

            $data = hooks()->apply_filters('before_lieferanten_added', $data);
            $this->db->insert(db_prefix() . 'staff', array('email' => $data['email'], 'password' => app_hash_password(123456), 'active' => 1, 'is_not_staff' => 3, 'role' => 9999));
            $insert_id = $this->db->insert_id();

            $data['userid'] = $insert_id;
            $this->db->insert(db_prefix() . 'lieferanten', $data);
            $insert_id = $this->db->insert_id();

            hooks()->do_action('after_lieferanten_added', $insert_id);
            log_activity('New lieferanten Added [' . $data['lieferanten_id'] . ']');

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
    public function change_lieferanten_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'lieferanten', [
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


        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['userid'] = get_staff_user_id();
        /*  $data['belegt'] = $data['belegt'] == '1' ? 1 : 0;
          $data['tierhaltung'] = $data['tierhaltung'] == '1' ? 1 : 0;
          $data['mobiliert'] = $data['mobiliert'] == '1' ? 1 : 0;*/
        /*$date = str_replace('.', '-', $data['belegt_b']);
        $data['belegt_b'] = date("Y-m-d", strtotime($date));
        $date = str_replace('.', '-', $data['belegt_v']);
        $data['belegt_v'] = date("Y-m-d", strtotime($date));*/
        // $data['active'] = 1;

        $data = hooks()->apply_filters('before_lieferanten_updated', $data, $id);


        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'lieferanten', $data);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('after_lieferanten_updated', $id);
            log_activity('Wohnungen Updated [' . $data['id'] . ']');

            return true;
        }

        return $affectedRows > 0;
    }

    public function get_mieters()
    {
        $this->db->where(db_prefix() . 'mieters.active', 1);
        return $this->db->get(db_prefix() . 'mieters')->result_array();
    }

    public
    function delete($id)
    {
        $lieferanten = $this->get($id);
        if ($lieferanten) {
            $this->db->where('id', $lieferanten->userid);
            $this->db->delete(db_prefix() . 'staff');
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'lieferanten');
            return true;
        }

        return false;
    }

}
