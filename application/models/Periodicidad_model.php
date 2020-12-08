<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

/**
* Clase Periodicidad_model. 
*Modelo para la gestión de los periodos de pago
* diciembre de 2020
**/
class Periodicidad_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Método exists.
     * Comprobación de la existencia de un periodo
     * Params: $periodicidad_id
     * Return: true, si hay un registro, false en cualquier otro caso.
	 */
	public function exists($periodicidad_id) {
		$this->db->from('periodicidad');
		$this->db->where('id', $periodicidad_id);
		return ($this->db->get()->num_rows() == 1 );
	}
	/**
	 * Método get_info.
     * Devuelve todos los datos del registro solicitado
     * Params: $periodicidad_id
     * Return: El registro solicitado completo, si existe.
	 */
	public function get_info( $periodicidad_id ) {
		$this->db->from('periodicidad');
		$this->db->where('id', $periodicidad_id);
		$query = $this->db->get();

		if ( $query->num_rows()  == 1 ) {
			return $query->row();
		}
	}

	/**
	 * Método gest_periodicidad_array.
     * Devuelve un array con el listado de periodos para el formulario de altas/modificaciones
     * Return: array con todos los id y periodos de la tabla
	 */
	public function get_periodicidad_array() {

		$periodicidad = $this->get_all();
		$opciones = array('' => 'Seleccione un periodo');
		foreach ($periodicidad->result() as $row) {
			$opciones[$row->id] = $row->nombre;
		}
		return $opciones;
	}

	/**
	 * Método get_periodicidad.
     * Devuelve el nombre del periodo solicitado por su id
     * Params: $periodicidad_id
     * Return: El nombre del periodo
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
	 * Método get_all.
     * Devuelve todos los registros de periodo
     * Return: todos los registrso de periodo
	 */
	public function get_all( $limit = 10000, $offset = 0 ) {
		$this->db->from('periodicidad');
		$this->db->order_by('periodicidad', 'asc');
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
	}

	/**
	 * Guardamos los datos del periodo
	 */
	public function save( &$periodicidad_data, $periodicidad_id = false ) {
		if (!$periodicidad_id || !$this->exists($periodicidad_id) ){
			if( $this->db->insert('periodicidad', $periodicidad_data)){
				$periodicidad_data['id'] = $this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $periodicidad_id);
		return $this->db->update('periodicidad', $periodicidad_data);
	}


	/**
	 * Elimina el periodo
	 */
	public function delete( $periodicidad_id ) {
		$success = false;
		$this->db->trans_start();
		$this->db->delete('periodicidad', array('id' => $periodicidad_id));
		$this->db->trans_complete();
		$success = $this->db->trans_status();
		return $success;
	}

}