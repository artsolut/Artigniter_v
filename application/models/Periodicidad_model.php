<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Periodicidad_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Obtiene todas las periodicidades de la base de datos
	 */
	public function get_all( $limit = 10000, $offset = 0 ) {
		$this->db->from('periodicidad');
		$this->db->order_by('periodicidad', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}

	/**
	 * Obtiene el texto de una periodicidad dada por el id
	 */
	public function get_periodicidad($periodicidad_id) {
		$this->db->from('periodicidad');
		$this->db->where('id', $periodicidad_id);
		$query = $this->db->get();

		if( $query->num_rows() ){
			return $query->row()->periodicidad;
		}
	}

	/**
	 * Obtiene el array de areas para el formulario
	 */
	public function get_periodicidad_array() {

		$periodos = $this->get_all();
		$opciones = array('' => 'Seleccione una periodicidad');
		foreach ($periodos->result() as $row) {
			$opciones[$row->id] = $row->periodicidad;
		}
		return $opciones;
	}

}