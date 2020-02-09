<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Configuracion_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('url', 'form');
	}

	/**
	 * Obtiene la tabla configuracion
	 */
	public function get_configuracion() {

		// Leemos los datos de configuración del único registro existente en esta tabla
		
		$this->db->from('configuracion');
		$this->db->limit(1);
		$query = $this->db->get();
		if ( $query->num_rows() == 1 ){
			return $query->row();
		} else {
			$config_obj = new stdClass;
			foreach ($this->db->list_fields('configuracion') as $field) {
				$config_obj->$field = '';
			}
			return $config_obj;
		}
	}
	
	public function update_config(&$config_data, $id = -1){
		$this->db->where( 'id', $id );
		return $this->db->update('configuracion', $config_data );
	}
	
	protected function nameize($string) {
		return str_name_case($string);
	}

}