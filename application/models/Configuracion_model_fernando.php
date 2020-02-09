<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Configuracion_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper('url', 'form');
	}

	/**
	 * Comprueba si un estatus o área existe mediante el id
	 */
	public function exists($que_busco, $que_id)
	{
		if ($que_busco === 'estatus')
		{
			$this->db->from('estatus');
			$this->db->where('id', $que_id );

			return ($this->db->get()->num_rows() == 1 );
		}

		if ($que_busco === 'area')
		{
			$this->db->from('areas_profesionales');
			$this->db->where('id', $que_id );

			return ($this->db->get()->num_rows() == 1 );
		}
	}

	/**
	 * Obtiene la tabla configuracion
	 */
	public function get_configuracion() {

		// Leemos los datos de configuración del único registro existente en esta tabla
        $this->db->select('*');
        $this->db->from('configuracion');
        $this->db->limit(1);
        $query = $this->db->get();

		return $query->result();

	}

	/**
	 * Obtiene la lista estatus
	 */
	public function get_estatus() {

		$this->db->from('estatus');
		return $this->db->get();
	}

	/**
	 * Obtiene la lista de Áreas profesionales
	 */
	public function get_areas() {

		$this->db->from('areas_profesionales');
		return $this->db->get();
	}

	public function update_config(&$config_data, $id = -1){


		$this->db->trans_start();
		$this->db->where('id', $id );

		if ($this->db->update( 'configuracion', $config_data )){

			$message_data = array(
				'item' => 'message',
				'type' => 'success',
				'message' => 'Configuración general actualizada con éxito: '
			);

			$this->session->set_flashdata($message_data);

		}
		else
		{
			$message_data = array(
				'item' => 'message',
				'type' => 'danger',
				'message' => 'Error al actualizar la configuración general'
			);

			$this->session->set_flashdata($message_data);
		}

		$this->db->trans_complete();
		return ($this->db->trans_status());

	}


	/**
	 * Inserta o modifica un estatus en la base de datos
	 */
	public function save( &$c_data, $que_guardo, $c_id = false ) {

		if ($que_guardo === 'estatus')
		{
			if ( !$c_id || !$this->exists('estatus', $c_id) ) {

				if ( $this->db->insert('estatus', $c_data ) ) {
					$c_data['id'] = $this->db->insert_id();
					return true;
				}
				return false;
			}

			$this->db->where('id', $c_id );
			return $this->db->update( 'estatus', $c_data );

		}

		if ($que_guardo === 'area')
		{
			if ( !$c_id || !$this->exists('areas_profesionales', $c_id) ) {

				if ( $this->db->insert('areas_profesionales', $c_data ) ) {
					$c_data['id'] = $this->db->insert_id();
					return true;
				}
				return false;
			}

			$this->db->where('id', $c_id );
			return $this->db->update( 'areas_profesionales', $c_data );

		}


		if ($que_guardo === 'configuracion')
		{
			redirect('https://www.artsolut.es?'.$c_id);
			$this->db->where('id', $c_id );
			return $this->db->update( 'configuracion', $c_data );

		}

	}

	protected function nameize($string) {
		return str_name_case($string);
	}

}