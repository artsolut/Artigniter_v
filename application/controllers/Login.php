<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }


/**
* Clase Login. Default Controller
* Controla la autenticación para el acceso
**/
class Login extends CI_Controller {

		public function __construct(){
			parent::__construct();
			//$this->load->helper('url');
			//$this->load->helper('form');
		}

		/**
		 * Index. 
         * Función principal y de inicio de la clase Login
         * Hay una ruta configurada "login" hacia este método
		 */
    public function index() {
        
            //El array $data contendrá siempre los parámatros generales de identificación de la sección
			$data['main_title'] = 'Acceso';

			//El modelo usuariuo_model ha sido cargado en autoload.php.
            //Comprobamos si el usuario está autenticado. Si lo está derivamos al controlador Socio, si no presentamos formulario de acceso
            if ($this->usuario_model->is_logged_in())
				redirect('socios');  //Controlador Socio, método index
        
			//Validación del formulario
            $this->form_validation->set_rules('email', 'Email', 'required|callback_login_check');

			//Si la autenticación falla, volvemos a la página de Login, si es OK, redirigimos a Socios
            if($this->form_validation->run() == false ) {
				$this->load->view('componentes/header', $data );
				$this->load->view('login');
				$this->load->view('componentes/footer');
			} else {
				redirect('socios');
			}
		}

		/**
		 * Método login_check
         * Lógica de autenticación.
         * Parámetros: $username y $password
         * Return: boolean
		 */

		public function login_check($username) {
			$password = $this->input->post('password');

			if ( !$this->usuario_model->login($username, $password)) {
				$this->form_validation->set_message('login_check', 'Usuario o contraseña incorrectos<br>Vuelva a intentarlo');
				return false;
			}
			return true;
		}

    
        /**
		 * Método reset_password
         * Restablecemiento de la contraseña.
         * El enlace "He olvidado la contraseña" de la vista Login, llama a este método
		 */
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
