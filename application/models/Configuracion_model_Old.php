<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }
<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Configuracion_model extends CI_Model {

	public function exists($key) {
		$this->db->from('configuracion');
		$this->db->where('configuracion.key', $key );
		return ($this->db->get()->num_rows() == 1 );
	}

	public function get_all() {
		$this->db->from('configuracion');
		$this->db->order_by('key', 'asc');
		return $this->db->get();
	}

	public function get($key, $default = '') {
		$query = $this->db->get_where('configuracion', array('key' => $key ), 1 );
		if ( $query->num_rows()  == 1 ) {
			return $query->row()->value;
		}
		return $default;
	}

	public function save( $key, $value ) {
		$config_data = array(
			'key' => $key,
			'value' => $value
		);

		if ( !$this->exists($key)) {
			return $this->db->insert('configuracion', $config_data);
		}

		$this->db->where('key', $key );
		return $this->db->update('configuracion', $config_data);

	}


	public function batch_save($data) {
		$success = true;
		$this->db->trans_start();

		foreach ($data as $key => $value) {
			$success &= $this->save($key, $value);
		}
		$this->db->trans_complete();
		$success &= $this->db->trans_status();
		return $success;
	}


}