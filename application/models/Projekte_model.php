<?php

defined('BASEPATH') or exit('No direct script access allowed');

class projekte_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['wohnungen_model', 'mieter_model', 'staff_model', 'cars_model', 'clients_model']);

    }


    /**
     * Get projekte/s
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_projekte($where = [])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'projekte')->result_array();
    }

    /**
     * Get projekte/s
     * @param mixed $id projekte id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'projekte.id', $id);
            return $this->db->get(db_prefix() . 'projekte')->row();
        } else {
            return $this->db->get(db_prefix() . 'projekte')->result_array();
        }
    }

    public function get_attachments($id)
    {
        $this->db->where(['rel_id' => $id, 'rel_type' => 'projekte']);
        return $this->db->get(db_prefix() . 'files')->result_array();
    }

    public function add_attachment($insert_id, $data)
    {
        $this->db->insert(db_prefix() . 'files', [
            'rel_id' => $insert_id,
            'rel_type' => 'projekte',
            'file_name' => $data['file_name'],
            'filetype' => $data['file_type'],
            'staffid' => get_staff_user_id(),
            'dateadded' => date('Y-m-d H:i:s'),
            'attachment_key' => app_generate_hash(),
        ]);
    }

    public function delete_attachment($id)
    {

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'files');
    }

    /**
     * Get projekte/s
     * @param array $where perform where
     * @return mixed
     */

    public
    function is_duplicate($where = [])
    {
        $this->db->where($where);
        $res = $this->db->get(db_prefix() . 'projekte')->row();
        if ($res) {
            return true;
        }
        return false;
    }

    /**
     * Get projekte/s
     * @param mixed $id projekte id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public
    function get_ajax($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'projekte.id', $id);
            return $this->db->get(db_prefix() . 'projekte')->result_array()[0];
        } else {
            return array();
        }
    }


    public
    function clean()
    {
        $this->db->where('fullname', '');
        $this->db->where('vorname', '');
        $this->db->where('nachname', '');
        $this->db->delete(db_prefix() . 'projekte');
    }

    public
    function get_grouped($column)
    {
        $this->db->where($column . ' !=', '');
        $this->db->select($column);
        $this->db->group_by($column);
        $query = $this->db->get(db_prefix() . 'projekte');
        return $query->result_array();

    }

    public
    function mieters()
    {
        $ids = array();
        $idsArr = $this->get_grouped('mieter');
        foreach ($idsArr as $rr) {
            array_push($ids, intval($rr['mieter']));
        }
        if (count($ids) > 0) {
            $this->db->where_in('id', $ids);
            $query = $this->db->get(db_prefix() . 'mieters');
            return $query->result_array();
        }
        return [];

    }

    public
    function kundes()
    {
        $ids = array();
        $idsArr = $this->get_grouped('kunde');
        foreach ($idsArr as $rr) {
            array_push($ids, intval($rr['kunde']));
        }
        if (count($ids) > 0) {
            $this->db->where_in('userid', $ids);
            $query = $this->db->get(db_prefix() . 'clients');
            return $query->result_array();
        }
        return [];
    }

    public
    function aqs()
    {
        $ids = array();
        $idsArr = $this->get_grouped('aq');
        foreach ($idsArr as $rr) {
            array_push($ids, intval($rr['aq']));
        }
        if (count($ids) > 0) {
            $this->db->where_in('id', $ids);
            $query = $this->db->get(db_prefix() . 'wohnungen');
            return $query->result_array();
        }
        return [];
    }

    public
    function users()
    {
        $ids = array();
        $idsArr = $this->get_grouped('user');
        foreach ($idsArr as $rr) {
            array_push($ids, intval($rr['user']));
        }
        if (count($ids) > 0) {
            $this->db->where_in('staffid', $ids);
            $query = $this->db->get(db_prefix() . 'staff');
            return $query->result_array();
        }
        return [];
    }

    public
    function cars()
    {
        $ids = array();
        $idsArr = $this->get_grouped('cars');
        foreach ($idsArr as $rr) {
            array_push($ids, intval($rr['cars']));
        }
        if (count($ids) > 0) {
            $this->db->where_in('id', $ids);
            $query = $this->db->get(db_prefix() . 'cars');
            return $query->result_array();
        }
        return [];
    }

    public
    function get_betreuer_by($idBetreur)
    {
        $this->db->where(db_prefix() . 'projekte.betreuer', $idBetreur);
        return $this->db->get(db_prefix() . 'projekte')->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new projekte
     */
    public
    function add($data)
    {
        if ($data) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['userid'] = get_staff_user_id();
            $data['active'] = 1;

            $this->db->insert(db_prefix() . 'projekte', $data);
            return $this->db->insert_id();
        }
        return false;
    }


    /**
     * @param integer ID
     * @param integer Status ID
     * @return boolean
     * Update client status Active/Inactive
     */
    public
    function change_projekte_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'projekte', [
            'active' => $status,
        ]);

        if ($this->db->affected_rows() > 0) {
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
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'projekte', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return $affectedRows > 0;
    }

    public
    function delete($id)
    {
        $projekte = $this->get($id);
        if ($projekte) {
            $this->db->where_in('id', $id);
            $this->db->delete(db_prefix() . 'projekte');
            return true;
        }

        return false;
    }

}
