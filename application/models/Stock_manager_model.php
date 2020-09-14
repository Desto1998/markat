<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stock_manager_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get stock_manager/s
     * @param mixed $id stock_manager id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'stock_manager.id', $id);
            return $this->db->get(db_prefix() . 'stock_manager')->row();
        } else {
            return $this->db->get(db_prefix() . 'stock_manager')->result_array();
        }
    }

    public function get_by_userid($userid)
    {
        $this->db->where('user_id', $userid);
        return $this->db->get(db_prefix() . 'stock_manager')->row();
    }


    public function get_stock_manager($where = [])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'stock_manager')->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new stock_manager
     */
    public function add($data)
    {
        if ($data) {

         

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
           
            $data['user_id'] = get_staff_user_id();
            $data = hooks()->apply_filters('before_stock_manager_added', $data);

            $this->db->insert(db_prefix() . 'stock_manager', $data);
            $insert_id = $this->db->insert_id();

            hooks()->do_action('after_stock_manager_added', $insert_id);
            log_activity('New Stock Added [' . $data['stock_manager_id'] . ']');

            return $insert_id;
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
        $data = hooks()->apply_filters('before_stock_manager_updated', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'stock_manager', $data);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('after_stock_manager_updated', $id);
            log_activity('Wohnungen Updated [' . $data['id'] . ']');

            return true;
        }

        return $affectedRows > 0;
    }

   

}
