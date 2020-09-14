<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Belegungsplan_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mieter_model');
    }

    /**
     * Get occupations/s
     * @param mixed $id occupations id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */

    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'occupations.id', $id);
            return $this->db->get(db_prefix() . 'occupations')->row();
        } else {
            return $this->db->get(db_prefix() . 'occupations')->result_array();
        }
    }


    /**
     * @param integer ID
     * @param integer Status ID
     * @return boolean
     * Update client status Active/Inactive
     */
    public function change_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'occupations', [
            'active' => $status,
        ]);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('occupations_status_changed', [
                'id' => $id,
                'status' => $status,
            ]);

            log_activity('Occupations Status Changed [ID: ' . $id . ' Status(Active/Inactive): ' . $status . ']');

            return true;
        }

        return false;
    }

    /**
     * @param integer ID
     * @param date Reinigung_Dt
     * @return boolean
     * Update reinigung_dt with selected date
     */
    public function change_reinigung_date($id, $reinigung_dt)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'occupations', [
            'reinigung_dt' => $reinigung_dt,
        ]);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('occupations_appointment_changed', [
                'id' => $id,
                'reinigung_dt' => $reinigung_dt,
            ]);

            log_activity('Occupations Appointment Date Changed [ID: ' . $id . ' AppointmentDate: ' . $reinigung_dt . ']');

            return true;
        }

        return false;
    }

    /**
     * Get occupations/s
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_occupations($where = ['active' => 1])
    {
        $this->db->where($where);
        return $this->db->get(db_prefix() . 'occupations')->result_array();
    }

    /**
     * Get occupations/s
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_my_occupations()
    {
        $this->db->select("o.id as id,w.id as wohnungen,w.strabe as strabe,w.belegt as belegt,w.hausnummer as hausnummer,w.etage as etage,w.flugel as flugel,w.zimmer as zimmer,w.schlaplatze as schlaplatze,w.mobiliert as mobiliert,w.active as active,o.belegt_v as belegt_v,o.belegt_b as belegt_b,m.fullname,o.mieter as mieter,o.active");
        $this->db->from(db_prefix() . 'occupations as o');
        $this->db->join(db_prefix() . 'mieters as m', 'm.id = o.mieter', 'left');
        $this->db->join(db_prefix() . 'wohnungen as w', 'w.id = o.wohnungen', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }


    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new occupations
     */
    public function add($data)
    {

        if ($data) {
            if (isset($data['belegungsplan_id']))
                unset($data['belegungsplan_id']);


            if (isset($data['belegt_b'])) {
                $data['belegt_b'] = to_sql_datedv($data['belegt_b']);
                $data['belegt_v'] = to_sql_datedv($data['belegt_v']);

            }

            //custom changes
            if (isset($data['etage']))
                unset($data['etage']);
            if (isset($data['schlaplatze']))
                unset($data['schlaplatze']);
            if (isset($data['mobiliert']))
                unset($data['mobiliert']);


            $data['belegt_b'] = to_sql_datedv($data['belegt_b']);
            $data['belegt_v'] = to_sql_datedv($data['belegt_v']);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if (isset($data['kein_m']))
                $data['mieter'] = 0;
            unset($data['kein_m']);

            if ($data['mieter'] == 0)
                $data['mieter_name'] = '';
            else
                $data['mieter_name'] = $this->mieter_model->get($data['mieter'])->fullname;

            $data['userid'] = get_staff_user_id();
            $data['active'] = 1;
            $this->db->insert(db_prefix() . 'occupations', $data);
            $insert_id = $this->db->insert_id();

            hooks()->do_action('after_occupations_added', $insert_id);
            log_activity('New occupations Added [' . $data['occupations_id'] . ']');

            return $insert_id;
        }

        return false;
    }


    public function get_grouped($column)
    {
        $this->db->select('w.' . $column);
        $this->db->where($column . ' !=', '');
        $this->db->from(db_prefix() . 'occupations as o');
        $this->db->join(db_prefix() . 'wohnungen as w', 'w.id = o.wohnungen', 'left');
        $this->db->group_by($column);
        $query = $this->db->get();
        return $query->result_array();

    }

    /**
     * @param integer ID
     * @param integer Status ID
     * @return boolean
     * Update client status Active/Inactive
     */
    public function change_occupations_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'occupations', [
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

        if (isset($data['belegt_b'])) {
            $data['belegt_b'] = to_sql_datedv($data['belegt_b']);
            $data['belegt_v'] = to_sql_datedv($data['belegt_v']);
        }

        //custom changes
        if (isset($data['etage']))
            unset($data['etage']);
        if (isset($data['schlaplatze']))
            unset($data['schlaplatze']);
        if (isset($data['mobiliert']))
            unset($data['mobiliert']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if (isset($data['belegungsplan_id']))
            unset($data['belegungsplan_id']);
        if (isset($data['kein_m']))
            $data['mieter'] = 0;
        unset($data['kein_m']);
        if ($data['mieter'] == 0)
            $data['mieter_name'] = '';
        else
            $data['mieter_name'] = $this->mieter_model->get($data['mieter'])->fullname;

        $data['userid'] = get_staff_user_id();

        /*$date = str_replace('.', '-', $data['belegt_b']);
        $data['belegt_b'] = date("Y-m-d", strtotime($date));
        $date = str_replace('.', '-', $data['belegt_v']);
        $data['belegt_v'] = date("Y-m-d", strtotime($date));*/
        // $data['active'] = 1;

        $data = hooks()->apply_filters('before_occupations_updated', $data, $id);


        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'occupations', $data);

        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('after_occupations_updated', $id);
            log_activity('occupations Updated [' . $data['id'] . ']');

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
        $occupations = $this->get($id);
        if ($occupations) {
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'occupations');
            return true;
        }

        return false;
    }

}
