<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Login extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->helper('url');
			$this->load->helper('form');
		}

		/**
		 * Página principal del login
		 */
    public function index() {
			$data['main_title'] = 'Acceso';

			if ($this->usuario_model->is_logged_in())
				redirect('intranet');
			$this->form_validation->set_rules('email', 'Email', 'required|callback_login_check');

			if($this->form_validation->run() == false ) {
				$this->load->view('componentes/header', $data );
				$this->load->view('login');
				$this->load->view('componentes/footer');
			} else {
				redirect('intranet');
			}
		}

		/**
		 * Chequeamos el login con los datos del usuario
		 */

		public function login_check($username) {
			$password = $this->input->post('password');

			if ( !$this->usuario_model->login($username, $password)) {
				$this->form_validation->set_message('login_check', 'Usuario o contraseña incorrectos<br>Vuelva a intentarlo');
				return false;
			}
			return true;
		}

		public function reset_password() {

			$data['nestedview']['title'] = 'Restablecer contraseña';

			if (isset($_POST['email']) && !empty($_POST['email'])) {
				$this->load->library('form_validation');

				$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[6]|max_length[50]|valid_email|xss_clean');

				if ( $this->form_validation->run() == false ) {
					$data['error'] = 'El correo suministrado no existe en nuestro sistema.';
					$this->load->view('login/reset_password');
				}

			} else {
				$this->load->view('login/reset_password', $data);
			}
		}
}
