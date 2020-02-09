<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Socio_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Comprueba si un socio existe mediante el id
	 */
	public function exists($socio_id) {
		$this->db->from('socio');
		$this->db->where('socio.id', $socio_id );

		return ($this->db->get()->num_rows() == 1 );
	}

	/**
	 * Obtiene la lista de socios completa
	 */
	public function get_all( $limit = 10000, $offset = 0 ) {

		$this->db->from('socio');
		$this->db->where('eliminado', 0);
		$this->db->order_by('apellido1', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}

	/**
	 * Obtenemos el numero total de socios
	 */
	public function get_total_rows() {
		$this->db->from('socio');
		$this->db->where('eliminado', 0);
		return $this->db->count_all_results();
	}

	/**
	 * Obtenemos la info de un socio dado por id
	 */
	public function get_info( $socio_id ) {
		$query = $this->db->get_where('socio', array('socio.id' => $socio_id ), 1);
		if ( $query->num_rows() == 1 ){
			return $query->row();
		} else {
			$socio_obj = new stdClass;
			foreach ($this->db->list_fields('socio') as $field ) {
				$socio_obj->$field = '';
			}
			return $socio_obj;
		}
	}

	/**
	 * Inserta o modifica un socio en la base de datos
	 */
	public function save( &$socio_data, $socio_id = false ) {
		if ( !$socio_id || !$this->exists($socio_id) ) {
			if ( $this->db->insert('socio', $socio_data ) ) {
				$socio_data['id_socio'] = $this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $socio_id );
		return $this->db->update( 'socio', $socio_data );
	}


	/**
	 * Determina si un socio esta logeado
	 */
	public function is_logged_in() {
		return ($this->session->userdata('id_socio') != false );
	}


	public function get_logged_in_socio_info() {
		if($this->is_logged_in()) {
			return $this->get_info($this->session->userdata('id_socio'));
		}
		return false;
	}


	public function delete( $socio_id ) {
		
	}

	protected function nameize($string) {
		return str_name_case($string);
	}

}