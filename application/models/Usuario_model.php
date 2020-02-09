<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Usuario_model extends Socio_model {

    /**
     * Constructor del modelo
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    public function exists($user_id) {
		$this->db->from('usuario');
		$this->db->join('socio', 'socio.id = usuario.id_socio');
		$this->db->where('usuario.id_socio', $user_id);
		return ($this->db->get()->num_rows() == 1 );
    }

    /**
     * Comprobamos si el correo introducido existe en la tabla de usuarios
     */
    public function check_mail($mail) {
        $this->db->from('usuario');
        $this->db->where('username', $mail);
        return ( $this->db->get()->num_rows() == 1 );
    }

    public function get_all($limit = 10000, $offset = 0 ) {

        $this->db->from('usuarios');
        $this->db->join('socio', 'socio.id = usuario.id_socio');
        $this->db->where('eliminado', 0);
        $this->db->order_by('apellido1');
        $this->db->limit($limit);
        $this->db->offset($offset);
       return $this->db->get();
    }

    /**
     * Obtenemos la info del usuario dado por $user_id
     */
    public function get_info($user_id) {
        $this->db->from('usuario');
        $this->db->join('socio', 'socio.id = usuario.id_socio');
        $this->db->where('usuario.id_socio', $user_id);
        $query = $this->db->get();

        if ( $query->num_rows() == 1 ) {
            return $query->row();
        } else {
            $user_obj = parent::get_info(-1);
            foreach ($this->db->list_fields('socio') as $field ) {
                $user_obj->$field = '';
            }
            return $user_obj;
        }
    }

    /**
     * Login del usuario
     */
    public function login( $username, $password ) {
        $query = $this->db->get_where('usuario', array('username' => $username, 'eliminado' => 0), 1 );

        if( $query->num_rows() == 1 ) {
            $row = $query->row();
            if ( password_verify($password, $row->password ) ) {
				$this->session->set_userdata('id_socio', $row->id_socio );
				$this->session->set_userdata('email', $row->username);
				$this->session->set_userdata('nivel', $row->nivel);
                return true;
            }
        }
        return false;
    }

    /**
     * Función para destruir la sesión y salir a la pantalla de login
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    /**
     * Comprueba si un usuario esta logeado
     */
    public function is_logged_in() {
        return ($this->session->userdata('id_socio') != false );
    }

    /**
     * Obtenemos los datos del usuario logeado
     */

    public function get_logged_in_usuario_info() {
        if ( $this->is_logged_in()) {
            return $this->get_info($this->session->userdata('id_socio'));
        }
        return false;
	}

	public function save_user(&$socio_data, &$usuario_data, $socio_id = false ) {
		$success = false;

		$this->db->trans_start();

		if( parent::save( $socio_data, $socio_id ) ) {
			if ( !$socio_id || !$this->exists($socio_id) ){
				$usuario_data['id_socio'] = $socio_id = $socio_data['id_socio'];
				$success = $this->db->insert('usuario', $usuario_data);
			} else {
				$this->db->set('username', $usuario_data['username']);
				$this->db->where('id_socio', $socio_id );
				$success = $this->db->update('usuario');
			}
		}

		$this->db->trans_complete();

		$success &= $this->db->trans_status();
		return $success;
	}
}