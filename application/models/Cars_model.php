<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cars_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get cars/s
     * @param mixed $id cars id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'cars.id', $id);
            return $this->db->get(db_prefix() . 'cars')->row();
        } else {
            return $this->db->get(db_prefix() . 'cars')->result_array();
        }
    }


    /**
     * Get cars/s
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_carss($where = [])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'cars')->result_array();
    }

    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new cars
     */
    public function add($data)
    {
        if ($data) {

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['tuv'] = to_sql_datedv($data['tuv']);
            $data['asu'] = to_sql_datedv($data['asu']);
            $data['inspektion'] = to_sql_datedv($data['inspektion']);
            $data['active'] = 1;
            $this->db->insert(db_prefix() . 'cars', $data);
            $insert_id = $this->db->insert_id();

            hooks()->do_action('after_cars_added', $insert_id);
            log_activity('New cars Added [' . $data['cars_id'] . ']');

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
    public function change_cars_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'cars', [
            'active' => $status,
        ]);
        if ($this->db->affected_rows() > 0) {
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
        $data['tuv'] = to_sql_datedv($data['tuv']);
        $data['asu'] = to_sql_datedv($data['asu']);
        $data['inspektion'] = to_sql_datedv($data['inspektion']);


        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'cars', $data);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('after_cars_updated', $id);
            log_activity('Wohnungen Updated [' . $data['id'] . ']');

            return true;
        }

        return $affectedRows > 0;
    }

    public function add_attachment($insert_id, $data)

    {

        $this->db->insert(db_prefix() . 'files', [

            'rel_id' => $insert_id,

            'rel_type' => 'cars',

            'file_name' => $data['file_name'],

            'filetype' => $data['file_type'],

            'staffid' => get_staff_user_id(),

            'dateadded' => date('Y-m-d H:i:s'),

            'attachment_key' => app_generate_hash(),

        ]);

    }

    public function delete($id)
    {
        $cars = $this->get($id);
        if ($cars) {
            $this->db->where_in('id', $id);
            $this->db->delete(db_prefix() . 'cars');
            return true;
        }

        return false;
    }

    public function delete_attachment($id)

    {

        $this->db->where('id', $id);

        $this->db->delete(db_prefix() . 'files');

    }
    public function get_attachments($id)

    {

        $this->db->where(['rel_id' => $id, 'rel_type' => 'cars']);

        return $this->db->get(db_prefix() . 'files')->result_array();

    }

}
