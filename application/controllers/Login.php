<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }


/**
* Clase Login. Default Controller
* Controla la autenticación para el acceso
**/
class Login extends CI_Controller {

		public function __construct(){
			parent::__construct();
            $this->load->model('Configuracion_model');
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
			$data['nestedview']['main_title'] = 'Acceso';  // Para el title de cada página
            //$data['nestedview']['title'] = 'Acceso'; //Para el breadcrumb

			//El modelo usuariuo_model ha sido cargado en autoload.php.
            //Comprobamos si el usuario está autenticado. Si lo está derivamos al controlador Socio, si no presentamos formulario de acceso
            if ($this->usuario_model->is_logged_in())
				
                redirect('socios');  //Controlador Socio, método index
        
			//Validación del formulario
            $this->form_validation->set_rules('email', 'Email', 'required|callback_login_check');

			//Si la autenticación falla, volvemos a la página de Login, si es OK, redirigimos a Socios
            if($this->form_validation->run() == false ) {
                $this->session->keep_flashdata();
				$this->load->view('componentes/header', $data );
				$this->load->view('login');
				$this->load->view('componentes/footer');
                
			} else {
                
                //redireccionamos de acuerdo al nivel de acceso
                
                switch ($this->session->userdata('nivel')) 
                {
                    case 1:
                        redirect ('socios');
                        break;
                    case 2:
                        redirect ('socios');
                        break;
                    case 3:
                        redirect ('socio/socio_view');
                        break;
                    default:
                        $this->usuario_model_logout();
                        break;
                }
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

			//Si el post email existe y no está vacío
            if (isset($_POST['email']) && !empty($_POST['email'])) {
	
                //Cargamos librerías
                $this->load->library('form_validation');
                $this->load->helper('security');

				//validamos
                $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[6]|max_length[50]|valid_email|xss_clean');

				//Si no tiene un formato válido devolvemos al formulario
                if ( $this->form_validation->run() == false ) {
                    
					$this->load->view('login/reset_password', $data);
                    
				}else{
                    
                    //Si el formato es válido comprobamos que el email existe en la BBDD
                    $check_email = $this->socio_model->check_mail($_POST['email']);
                    
                    if ($check_email != null){
                        
                        // Si existe almacenamos clave de control y enviamos e-mail 
                        $this->load->library("encryption");
                        $key_control = mt_rand();
                        $string_recovery = $this->encryption->encrypt($key_control);
                        $url_recovery = base_url()."login/change_password/".$check_email."/".$key_control;
                        
                        //Almacenamos 
                        if ($this->socio_model->control_change_pass($string_recovery, $check_email)){
    
                            $message_recovery = "Hola. Si has solicitado la recuperación de la contraseña, haz clic en <strong><a href='". $url_recovery ."'>este enlace</a></strong> para iniciar el proceso, en caso contrario elimina este correo.";


                            $config = $this->Configuracion_model->get_configuracion();

                            $config = Array(
                                'protocol' => 'smtp',
                                'smtp_host' => $this->encryption->decrypt($config->smtp),
                                'smtp_port' => 587,
                                'smtp_user' => $this->encryption->decrypt($config->email_emisor),
                                'smtp_pass' => $this->encryption->decrypt($config->password),
                                'mailtype' => 'html',
                                'charset' => 'utf-8',
                                'newline' => "\r\n",
                                'smtp_timeout'   =>   7,
                                'smtp_crypto'   =>   'tls',
                                'smtp_debug'   =>   0,
                                'wordwrap'   =>   TRUE,
                                'wrapchars'   =>   76,
                                'mailtype'   =>   'html',
                                'charset'   =>   'utf-8',
                                'validate'   =>   TRUE,
                                'crlf'   =>   "\r\n",
                                'newline'   =>   "\r\n",
                                'bcc_batch_mode'   =>   false,
                                'bcc_bath_size'   =>   200
                            );

                            $this->load->library('email');
                            $this->email->initialize($config);
                            $this->email->from($config['smtp_user'], 'Dip');


                            $this->email->to($_POST['email']);
                            $this->email->subject('Dip. Recuperación de contraseña');
                            $this->email->message($message_recovery);


                            if ($this->email->send()){

                                $this->session->set_flashdata("success", "Se ha enviado un correo a la dirección de e-mail facilitada.");
                                $this->load->view('login/reset_password', "refresh");

                            }else{

                                //si ocurre algún error en el envío mostramos lista de errores.
                                show_error($this->email->print_debugger());
                            }
                        }else{
                            
                        }    
                        
                    }else{
                        
                        // Si no existe redirigimos con mensaje de error
                        $data['errormsg'] = 'Lo sentimos, este correo no está registrado.';
                        $this->load->view('login/reset_password', $data);
                    }

                }

			} else {
				$this->load->view('login/reset_password', $data);
			}
		}
    
    
        /**
		 * Método change_password
         * Muestra un formulario en el que introducir la contraseña y la comprobación.
         * El método compara el parámetro de la url con la clave almacenada en bbdd y si es ok, la elimina.
         * PARAMS: clave de control - $key
         * RETURN: boolean
		 */
		public function change_password($id_socio, $key) {
            
            $data['nestedview']['title'] = 'Cambiar contraseña';
            
			//Si el formulario de cambio ya ha sido completado
            if (isset($_POST['id_socio']) && !empty($_POST['key_url'])) {
                //Cargamos librerías
                $this->load->library('form_validation');
                $this->load->helper('security');

				//validamos
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
                $this->form_validation->set_rules('re-password', 'Password confirmación', 'trim|required|min_length[8]|matches[password]');
               

				//Si no se cumplen devolvemos al formulario
                if ( $this->form_validation->run() == false ) {
					$this->load->view('login/change_password', $data);
                    
				}else{
                    //Si el formato es válido capturamos los POST
                    $id_socio = $_POST['id_socio'];
                    $key_url = $_POST['key_url'];
                    $pass = $_POST['password'];
                    $pass2 = $_POST['re-password'];
                    
                    //Comprobamos de nuevo las password y si fuera incorrecto devolvemos al formulario con mensaje de error
                    if ($pass !== $pass2)
                        $data['errormsg'] = 'Los passwords no coinciden.';
                        $this->load->view('login/change_password', $data);
                     
                    // Si todo es Ok, leemos clave de control del registro
                    $socio = $this->socio_model->get_info($id_socio);
                    //desciframos para comparar
                    $this->load->library("encryption");
                    $key_saved = $this->encryption->decrypt($socio->recuperar);


                    if ($key_url == $key_saved){

                        //Almacenamos nueva contraseña
                        if ($this->usuario_model->save_new_pass($pass, $id_socio)){
                             
                            $this->session->set_flashdata("success", "Contraseña actualizada. Autentíquese de nuevo.");
                            redirect($base_url."/login/");
                     
                            
                        }else{
                            
                            $this->session->set_flashdata("errormsg", "Ha ocurrido un error, inténtelo de nuevo más tarde.");
                            redirect($base_url."/login/");
                        }
                            
                        

                    }else{
                        $this->session->set_flashdata("errormsg", "Este acceso no está autorizado");
                        $this->load->view('login/change_password', "refresh");

                    }
                        

                }
            //Si venimos desde el enlace al correo, cargamos el formulario change_password
			} else {
                $data['key_url'] = $key;
                $data['id_socio'] = $id_socio;
				$this->load->view('login/change_password', $data);
			}
            
        }
}
