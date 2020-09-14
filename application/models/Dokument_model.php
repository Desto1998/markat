<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokument_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get dokumente/s
     * @param mixed $id dokumente id
     * @param array $where perform where
     * @param boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get($id = '', $where = [], $for_editor = false)
    {
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'dokumente.id', $id);
            return $this->db->get(db_prefix() . 'dokumente')->row();
        } else {
            return $this->db->get(db_prefix() . 'dokumente')->result_array();
        }
    }


    public function can_make_dok($mieter)
    {

        $this->db->select('c.company as kunde, m.fullname as mieter, m.etage as etage, m.strabe_m as strabe, m.hausnummer_m as nr, m.plz as plz, m.stadt as stadt');
        $this->db->select('m.beraumung as beraumung, m.ruckraumung as ruckraumung, m.stadt as stadt');
        $this->db->select('p.auftrag as auftrag, p.wie as wie, p.nummer as nummer');
        $this->db->select('w.plz as aq_zip, w.hausnummer as aq_nr, w.ort as aq_ort, w.strabe as aq_strabe');
        $this->db->where('m.id', $mieter);
        $this->db->from(db_prefix() . 'occupations as o');
        $this->db->join(db_prefix() . 'mieters as m', 'm.id = o.mieter', 'INNER');
        $this->db->join(db_prefix() . 'projekte as p', 'p.mieter = m.id', 'INNER');
        $this->db->join(db_prefix() . 'clients as c', 'c.userid = p.kunde', 'INNER');
        $this->db->join(db_prefix() . 'wohnungen as w', 'w.id = o.wohnungen', 'INNER');

        $query = $this->db->get()->result_array();
        if ($query)
            return $query[0];
        return false;
    }

    /**
     * @param array $_POST data
     * @return  integer Insert ID
     * Add new dokumente
     */
    public function add($_data)
    {
        $mieter = $_data['mieter'];
        if (is_numeric($mieter)) {
            $response = $this->can_make_dok($mieter);
            if (!$response)
                return false;
            $data['client'] = $response['kunde'];
            $data['mieter'] = $response['mieter'];
            $data['strabe'] = $response['strabe'];
            $data['json_data'] = serialize($_data['x']);
            $data['nr'] = $response['nr'];
            $data['plz'] = $response['plz'];
            $data['ort'] = $response['stadt'];
            $data['aq_ort'] = $response['aq_ort'];
            $data['aq_zip'] = $response['aq_zip'];
            $data['aq_strabe'] = $response['aq_strabe'];
            $data['aq_nr'] = $response['aq_nr'];
            $data['auftrag'] = $response['auftrag'];
            $data['wie'] = $response['wie'];
            $data['projeckt'] = $response['nummer'];
            $data['etage'] = $response['etage'];
            $data['datum'] = $response['beraumung'];
            $data['beraumung'] = $response['beraumung'];
            $data['ruckraumung'] = $response['ruckraumung'];
            $data['fo_arbeit'] = $_data['fo_arbeit'];
            $data['demontage'] = $data['beraumung'];
            $data['e_datum'] = $data['beraumung'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->insert(db_prefix() . 'dokumente', $data);
            update_option('standar_modal_doc', $data['json_data']);
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
    public function change_dokumente_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'dokumente', [
            'active' => $status,
        ]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Status Changed [ID: ' . $id . ' Status(Active/Inactive): ' . $status . ']');

            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $dokumente = $this->get($id);
        if ($dokumente) {
            $this->db->where_in('id', $id);
            $this->db->delete(db_prefix() . 'dokumente');
            return true;
        }

        return false;
    }

}
