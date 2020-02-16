<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

/**
* Clase Provincia_model. 
* Modelo para la gestión de provincias
* Febrero de 2020
**/
class Provincia_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Método get_provincia_array.
     * Devuelve un array con el listado de provincias para el formulario de altas/modificaciones
     * Return: array con todos los id y provincias de la tabla
	 */
	public function get_provincia_array() {

		$provincia = $this->get_all();
		$opciones = array('' => 'Seleccione una provincia');
		foreach ($provincia->result() as $row) {
			$opciones[$row->id] = $row->provincia;
		}
		return $opciones;
	}

	/**
	 * Método get_provincia.
     * Devuelve el nombre de la provincia solicitada por su id
     * Params: $provincia_id
     * Return: El nombre de la provincia
	 */
	public function get_provincia ($provincia_id) {
		$this->db->from('provincia');
		$this->db->where('id', $provincia_id);
		$query = $this->db->get();

		if( $query->num_rows() ){
			return $query->row()->provincia;
		}
	}

	/**
	 * Método get_all.
     * Devuelve todos los registros de provincias
     * Return: todos los registrso de provincias
	 */
	public function get_all( $limit = 10000, $offset = 0 ) {
		$this->db->from('provincia');
		$this->db->order_by('provincia', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}
}