<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Estatus_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Comprobamos si existe el estatus
	 */
	public function exists($area_id) {
		$this->db->from('estatus');
		$this->db->where('id', $area_id);
		return ($this->db->get()->num_rows() == 1 );
	}

	/**
	 * Obtiene la información del estatus
	 */
	public function get_info( $area_id ) {
		$this->db->from('estatus');
		$this->db->where('id', $area_id);
		$query = $this->db->get();

		if ( $query->num_rows()  == 1 ) {
			return $query->row();
		}
	}

	/**
	 * Obtiene el array de estatus para el formulario
	 */
	public function get_estatus_array() {

		$areas = $this->get_all();
		$opciones = array('' => 'Seleccione un estatus');
		foreach ($areas->result() as $row) {
			$opciones[$row->id] = $row->area;
		}
		return $opciones;
	}

	/**
	 * Obtiene el texto de un area dada por el id
	 */
	public function get_estatus($estatus_id) {
		$this->db->from('estatus');
		$this->db->where('id', $estatus_id);
		$query = $this->db->get();

		if( $query->num_rows() ){
			return $query->row()->estatus;
		}
	}

	/**
	 * Obtiene todos los estatus de la base de datos
	 */
	public function get_all( $limit = 10000, $offset = 0 ) {
		$this->db->from('estatus');
		$this->db->order_by('estatus', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}

	/**
	 * Guardamos los datos del estatus
	 */
	public function save( &$estatus_data, $estatus_id = false ) {
		if (!$estatus_id || !$this->exists($estatus_id) ){
			if( $this->db->insert('estatus', $estatus_data)){
				$estatus_data['id'] = $this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $estatus_id);
		return $this->db->update('estatus', $estatus_data);
	}


	/**
	 * Elimina el estatus
	 */
	public function delete( $estatus_id ) {
		$success = false;
		$this->db->trans_start();
		$this->db->delete('estatus', array('id' => $estatus_id));
		$this->db->trans_complete();
		$success &= $this->db->trans_status();
		return $success;
	}

}