<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

/**
* Clase Estatus_model. 
*Modelo para la gestión de los Estatus
* Febrero de 2020
**/
class Estatus_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Método exists.
     * Comprobación de la existencia de un estatus
     * Params: $estatus_id
     * Return: true, si hay un registro, false en cualquier otro caso.
	 */
	public function exists($estatus_id) {
		$this->db->from('estatus');
		$this->db->where('id', $estatus_id);
		return ($this->db->get()->num_rows() == 1 );
	}
	/**
	 * Método get_info.
     * Devuelve todos los datos del registro solicitado
     * Params: $estatus_id
     * Return: El registro solicitado completo, si existe.
	 */
	public function get_info( $estatus_id ) {
		$this->db->from('estatus');
		$this->db->where('id', $estatus_id);
		$query = $this->db->get();

		if ( $query->num_rows()  == 1 ) {
			return $query->row();
		}
	}

	/**
	 * Método gest_estatus_array.
     * Devuelve un array con el listado de estatus para el formulario de altas/modificaciones
     * Return: array con todos los id y estatus de la tabla
	 */
	public function get_estatus_array() {

		$estatus = $this->get_all();
		$opciones = array('' => 'Seleccione un estatus');
		foreach ($estatus->result() as $row) {
			$opciones[$row->id] = $row->estatus;
		}
		return $opciones;
	}

	/**
	 * Método get_estatus.
     * Devuelve el nombre del estatus solicitado por su id
     * Params: $estatus_id
     * Return: El nombre del estatus
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
	 * Método get_estatus_alias.
     * Devuelve el alias del estatus solicitado por su id
     * Params: $estatus_id
     * Return: El alias del estatus
	 */
	public function get_estatus_alias($estatus_id) {
		$this->db->from('estatus');
		$this->db->where('id', $estatus_id);
		$query = $this->db->get();

		if( $query->num_rows() ){
			return $query->row()->alias;
		}
	}
	/**
	 * Método get_all.
     * Devuelve todos los registros de estatus
     * Return: todos los registrso de estatus
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
		$success = $this->db->trans_status();
		return $success;
	}

}