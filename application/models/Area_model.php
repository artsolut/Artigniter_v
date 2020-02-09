<?php if (!defined('BASEPATH')) {die('Direct access not permited.');}

class Area_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Comprobamos si existe el area
	 */
	public function exists($area_id) {
		$this->db->from('area_profesional');
		$this->db->where('id', $area_id);
		return ($this->db->get()->num_rows() == 1 );
	}

	/**
	 * Obtiene la información del area
	 */
	public function get_info( $area_id ) {
		$this->db->from('area_profesional');
		$this->db->where('id', $area_id);
		$query = $this->db->get();

		if ( $query->num_rows()  == 1 ) {
			return $query->row();
		}
	}

	/**
	 * Obtiene el array de areas para el formulario
	 */
	public function get_area_array() {

		$areas = $this->get_all();
		$opciones = array('' => 'Seleccione un área');
		foreach ($areas->result() as $row) {
			$opciones[$row->id] = $row->area;
		}
		return $opciones;
	}

	/**
	 * Obtiene el texto de un area dada por el id
	 */
	public function get_area($area_id) {
		$this->db->from('area_profesional');
		$this->db->where('id', $area_id);
		$query = $this->db->get();

		if( $query->num_rows() ){
			return $query->row()->area;
		}
	}

	public function get_all( $limit = 10000, $offset = 0 ) {
		$this->db->from('area_profesional');
		$this->db->order_by('area', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}

	/**
	 * Guardamos los datos del area profesional
	 */

	public function save( &$area_data, $area_id = false ) {
		if (!$area_id || !$this->exists($area_id) ){
			if( $this->db->insert('area_profesional', $area_data)){
				$area_data['id'] = $this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $area_id);
		return $this->db->update('area_profesional', $area_data);
	}

	/**
	 * Elimina el area profesional seleccionada
	 */
	public function delete( $area_id ) {
		$success = false;
		$this->db->trans_start();
		$this->db->delete('area_profesional', array('id' => $area_id));
		$this->db->trans_complete();
		$success &= $this->db->trans_status();
		return $success;
	}

}