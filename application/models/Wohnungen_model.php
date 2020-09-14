<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wohnungen_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wohnungen_inventar_model');
    }

    /**
     * Get wohnungen/s
     * @param mixed $id wohnungen id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $acttt = false)
    {
        $this->db->order_by('strabe', 'asc');
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'wohnungen.id', $id);
            $aq = $this->db->get(db_prefix() . 'wohnungen')->row();
            $aq->inventer = $this->getInventer($aq->id, $acttt);
            $aq->moved_items = $this->my_moved_items($aq->id);
            return $aq;
        } else {
            return $this->db->get(db_prefix() . 'wohnungen')->result_array();
        }
    }


    public function get_projekte()
    {
        $project = $this->get_grouped('project');
        if (!$project) return array();
        $project_ids = array();
        foreach ($project as $p) {
            array_push($project_ids, $p['project']);
        }
        $this->db->where_in('id', $project_ids);
        return $this->db->get(db_prefix() . 'tsk_project')->result_array();
    }

    /**
     * Get mieters/s
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_wohnungens($where = ['active' => 1])
    {
        $this->db->where($where);
        $this->db->order_by('strabe', 'asc');
//        $this->db->group_by(array('strabe','hausnummer'));
        $this->db->select('occupations.*');
        $this->db->select('wohnungen.*');
        $this->db->join(db_prefix() . 'occupations', 'occupations.wohnungen = wohnungen.id', 'LEFT');

        return $this->db->get(db_prefix() . 'wohnungen')->result_array();
    }

    public function visualisierungGet($id = '', $type="even")
    {
        if($type =="even"){

        $this->db->where('MOD(wohnungsnumme,2)',0);
        }else{
        $this->db->where('MOD(wohnungsnumme,2)',1);
        }
        $this->db->select('occupations.*');
        $this->db->select('wohnungen.*');
        $this->db->join(db_prefix() . 'occupations', 'occupations.wohnungen = wohnungen.id', 'LEFT');
        $this->db->where_in(db_prefix() . 'wohnungen.id', $id);
        $this->db->order_by('wohnungsnumme', 'desc');
        return $this->db->get(db_prefix() . 'wohnungen')->result_array();


    }
    public function get_grouped($column)
    {
        $this->db->where($column . ' !=', '');
        $this->db->select($column);
        $this->db->group_by($column);
        $query = $this->db->get(db_prefix() . 'wohnungen');
        return $query->result_array();

    }

    // inventarlistes

    /**
     * Get leads inventarlistes
     * @param mixed $id Optional - inventarliste ID
     * @return mixed object if id passed else array
     */
    public function get_inventar($id = false)
    {
        $this->db->where('id', $id);
        return $this->db->get(db_prefix() . 'inventarliste')->row();
    }

    /**
     * Get leads inventarlistes
     * @param mixed $id Optional - inventarliste ID
     * @return mixed object if id passed else array
     */
    public function get_inventar_ad($id = false)
    {
        $this->db->where('inventar_id', $id);
        return $this->db->get(db_prefix() . 'inventarliste')->row()->name;
    }
    // inventarlistes

    /**
     * Get leads inventarlistes
     * @param mixed $id Optional - inventarliste ID
     * @return mixed object if id passed else array
     */
    public function get_inventarliste($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'inventarliste')->row();
        }

        $this->db->order_by('name', 'asc');

        return $this->db->get(db_prefix() . 'inventarliste')->result_array();
    }

    /**
     * Add new lead inventarliste
     * @param mixed $data inventarliste data
     */
    public function add_inventarliste($data)
    {
        $this->db->insert(db_prefix() . 'inventarliste', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
        }

        return $insert_id;
    }

    /**
     * Update lead inventarliste
     * @param mixed $data inventarliste data
     * @param mixed $id inventarliste id
     * @return boolean
     */
    public function update_inventarliste($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'inventarliste', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }


    public function getInventer($aq_id, $acttt = false)
    {
        $this->db->where('qty >', 0);
        $this->db->where('aq_id', $aq_id);
        $this->db->where('for', 0);
        if ($acttt) {
            $this->db->where('is_deleted', 0);
        }
        return $this->db->get(db_prefix() . 'wohnungen_inventar')->result_array();
    }


    public function getSingleInventer($id)
    {
        $this->db->where('id', $id);
        return $this->db->get(db_prefix() . 'wohnungen_inventar')->row();
    }

    /**
     * Delete lead inventarliste from database
     * @param mixed $id inventarliste id
     * @return mixed
     */
    public function delete_inventarliste($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'inventarliste');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function move($data)
    {

        $from = $data['aq_from'];
        $to = $data['aq_to'];
        $movables = $data['move'];
        if (count($movables) < 1)
            return false;
        $data = [];
        $_movables = [];
        $allInventar = $this->countInventatAq($from);
        $movendInventar = 0;
        foreach ($movables['inventory'] as $k => $movable) {
            /*     $movable = $movable[0];
             $qty = $qtys[$k][0];
             $inventars = $this->getSingleInventer($movable);
             if ($qtys[$k] > 0 && $inventars->qty >= $qty) {
                 $fromData = [];
                 $fromData['qty'] = $inventars->qty - $qty;
                 $this->db->where('id', $movable);
                 $this->db->update(db_prefix() . 'wohnungen_inventar', $fromData);
             }

             // check exist inventer in to aq

             $this->db->where('aq_id', $to);
             $this->db->where('inventar_id', $inventars->inventar_id);
             $response = $this->db->get(db_prefix() . 'wohnungen_inventar')->row();
             if ($response) {
                 $fromData['qty'] = $inventars->qty + $qty;
                 $this->db->where('id', $response->id);
                 $this->db->update(db_prefix() . 'wohnungen_inventar', $fromData);
             } else {
                 $data = [];
                 $data['created_at'] = date('Y-m-d H:i:s');
                 $data['qty'] = $qty;
                 $data['inventar_id'] = $inventars->inventar_id;
                 $data['aq_id'] = $to;
                 $data['is_deleted'] = 0;
                 $this->db->insert(db_prefix() . 'wohnungen_inventar', $data);
                 $insert_idInventar = $this->db->insert_id();
             }*/
            $qty = (int)$movables['qty'][$k][0];
            $_movables[] = array('inventory' => (int)$k, 'qty' => $qty, 'from' => $from, 'to' => $to);
            $movendInventar += $qty;
        }
        $data = [];
        $data['aq_from'] = $from;
        $data['aq_to'] = $to;
        $data['inventory'] = serialize($_movables);
        $data['item_counts'] = $allInventar;
        $data['items_move'] = $movendInventar;
        $data['items_rest'] = $allInventar - $movendInventar;
        $data['active'] = 1;
        $data['created_at'] = date('Y-m-d');
        $this->db->insert(db_prefix() . 'inventory_um', $data);
        $insert_id = $this->db->insert_id();
        return true;
    }

    private function countInventatAq($aq_id)
    {
        $counter = 0;
        $invetert = $this->getInventer($aq_id);
        if ($invetert) {
            foreach ($invetert as $inv) {
                $counter += $inv['qty'];
            }
        }
        return $counter;
    }


    public function my_moved_mys_items($id)
    {

        $this->db->where('aq_from', $id);
        $query = $this->db->get(db_prefix() . 'inventory_um');
        return $query->result_array();
    }

    public function my_moved_items($id)
    {

        $this->db->where('aq_from', $id);
        $query = $this->db->get(db_prefix() . 'inventory_um');
        return $query->result_array();
    }

    public function is_occuped($id)
    {
        $occupations = $this->get_occupations($id);
        foreach ($occupations as $occupation) {
            if ($id === $occupation['wohnungen']) {
                $bv = date("Y-m-d", strtotime($occupation['belegt_v']));
                $bb = date("Y-m-d", strtotime($occupation['belegt_b']));
                $noww = date('d.m.Y');
                if ($bv > $noww && $noww < $bb) {
                    return false;
                    break;
                }
            }
        }
        return true;
    }


    public function get_occupations($id)
    {
        $this->db->select('o.*');
        $this->db->select('w.*');
        $this->db->select('m.fullname as fullname');
        $this->db->from(db_prefix() . 'occupations  o');
        $this->db->join(db_prefix() . 'mieters m', 'm.id = o.mieter', 'LEFT');
        $this->db->join(db_prefix() . 'wohnungen w', 'w.id = o.wohnungen', 'LEFT');
        $this->db->where('o.wohnungen', $id);
        $query = $this->db->get(db_prefix() . 'occupations');
        return $query->result_array();
    }

    public function get_his_occupations($id)
    {
        $this->db->where('wohnungen', $id);
        $query = $this->db->get(db_prefix() . 'occupations');
        return $query->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new wohnungen
     */
    public function add($data)
    {
        if ($data) {

            $austattung = $data['austattung'];
            $a_qty = $data['a_qty'];
            $sqr = $data['sqr'];
            $deleteData = $data['delete'];
            $reasons = $data['reasons'];
            unset($data['a_qty']);
            unset($data['austattung']);
            unset($data['delete']);
            unset($data['sqr']);
            unset($data['reasons']);

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['userid'] = get_staff_user_id();
            $data['active'] = 1;

            $this->db->insert(db_prefix() . 'wohnungen', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id) {
                foreach ($austattung as $k => $item) {
                    if ($a_qty[$k] == 0)
                        continue;
                    $data = array('reason' => $reasons[$k],
                        'is_deleted' => (int)$deleteData[$k],
                        'for' => 0,
                        'qty' => $a_qty[$k], 'sqr' => $sqr[$k]);
                    if (!$this->wohnungen_inventar_model->exist($insert_id, $item)) {
                        $data['aq_id'] = $insert_id;
                        $data['inventar_id'] = $item;
                        $this->wohnungen_inventar_model->add($data);
                    } else {
                        $this->wohnungen_inventar_model->update($data, $insert_id, $item);
                    }
                }
            }

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
    public function change_wohnungen_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'wohnungen', [
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
        $austattung = $data['austattung'];
        $a_qty = $data['a_qty'];
        $sqr = $data['sqr'];
        $deleteData = $data['delete'];
        $reasons = $data['reasons'];
        unset($data['a_qty']);
        unset($data['austattung']);
        unset($data['delete']);
        unset($data['sqr']);
        unset($data['reasons']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['userid'] = get_staff_user_id();

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'wohnungen', $data);
        foreach ($austattung as $k => $item) {
            if ($a_qty[$k] == 0)
                continue;
            $data = array('reason' => $reasons[$k],
                'is_deleted' => (int)$deleteData[$k],
                'qty' => $a_qty[$k],
                'sqr' => $sqr[$k]);
            if (!$this->wohnungen_inventar_model->exist($id, $item)) {
                $data['aq_id'] = $id;
                $data['inventar_id'] = $item;
                $this->wohnungen_inventar_model->add($data);
            } else {
                $this->wohnungen_inventar_model->update($data, $id, $item);
            }
        }
        return true;

    }

    public function get_mieters()
    {
        $this->db->where(db_prefix() . 'mieters.active', 1);
        return $this->db->get(db_prefix() . 'mieters')->result_array();
    }

    public
    function delete($id)
    {

        $has = $this->get_occupations($id);
        if (!$has) {
            $wohnungen = $this->get($id);
            if ($wohnungen) {
                $this->db->where('id', $id);
                $this->db->delete(db_prefix() . 'wohnungen');
                return true;
            }
        } else {
            return false;
        }
    }

    public
    function delete_um($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'inventory_um');
        return true;
    }

}
