<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wohnungen_inventar_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get wohnungen_inventar/s
     * @param mixed $id wohnungen_inventar id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'wohnungen_inventar.id', $id);
            return $this->db->get(db_prefix() . 'wohnungen_inventar')->row();
        } else {
            return $this->db->get(db_prefix() . 'wohnungen_inventar')->result_array();
        }
    }

    public function exist($aq, $invent)
    {
        $this->db->where('aq_id', $aq);
        $this->db->where('inventar_id', $invent);
        return $this->db->get(db_prefix() . 'wohnungen_inventar')->row();

    }


    public function get_wohnungen_inventars($where = [])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'wohnungen_inventar')->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new wohnungen_inventar
     */
    public function add($data)
    {

        if ($data) {
            $data['created_at'] = date('Y-m-d H:i:s');
            if (!isset($data['is_deleted']) || empty($data['is_deleted']))
                $data['is_deleted'] = 0;
            $this->db->insert(db_prefix() . 'wohnungen_inventar', $data);
            $insert_id = $this->db->insert_id();

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
    function update($data, $aq_id, $inventar)
    {
        $affectedRows = 0;
        $this->db->where('aq_id', $aq_id);
        $this->db->where('inventar_id', $inventar);
        $this->db->update(db_prefix() . 'wohnungen_inventar', $data);

        if ($this->db->affected_rows() > 0) {

            return true;
        }

        return $affectedRows > 0;
    }

    public
    function delete($id)
    {
        $wohnungen_inventar = $this->get($id);
        if ($wohnungen_inventar) {
            $this->db->where('id', $wohnungen_inventar->userid);
            $this->db->delete(db_prefix() . 'staff');
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'wohnungen_inventar');
            return true;
        }

        return false;
    }

}
