<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Socio extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->model('Socio_model');
		$this->load->model('Configuracion_model');
		$this->load->model('Area_model');
        $this->load->model('Estatus_model');
		$this->load->helper('url', 'form');
		$this->load->library('form_validation');
		$this->errors = array();
    }

    public function index() {

		if ( !$this->Usuario_model->is_logged_in() )
			redirect('login');

        $socios_obj = $this->Socio_model->get_all();

        $data['nestedview']['main_title'] = 'Listado de Socios';
		$data['socios_data'] = $socios_obj;


		$this->mybreadcrumb->add( 'Socios', 'socios' );

		/** Asignamos el breadcrumb */
		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('socios/listado', $data );
	}

	public function view($socio_id = -1 ) {
		$socio_info = $this->socio_model->get_info($socio_id);

		foreach (get_object_vars($socio_info) as $property => $value) {
			$socio_info->$property = $value;
		}

		$data["socio_data"] = $socio_info;
		$data['main_title'] = '';

		$this->mybreadcrumb->add('Socios', 'socios');
		$this->mybreadcrumb->add('Nevo socio', 'socios/create');

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$data['errors'] = $this->errors;

		$this->load->view('socios/form', $data);
	}

	/**
	 * Guarda los datos del socio
	 */
	public function save( $socio_id = -1 ) {

		$data['main_title'] = '';

		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('apellido1', 'Primer apellido', 'trim|required');
		$this->form_validation->set_rules('apellido2', 'Segundo apellido', 'required');

		if ( $socio_id == -1 ) {
			$this->form_validation->set_rules('dni', 'DNI', 'trim|required|is_unique[socio.dni]');
		} else
			$this->form_validation->set_rules('dni', 'DNI', 'trim|required');

		$this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');
		$this->form_validation->set_rules('cp', 'Código postal', 'required|is_numeric');

		if($socio_id == -1 )
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[socio.email]');
		else
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		$this->form_validation->set_rules('telefono', 'Teléfono', 'required');
		$this->form_validation->set_rules('provincia', 'Provincia', 'required|callback_check_provincia');
		$this->form_validation->set_message('check_provincia', 'Seleccione una provincia.');
		$this->form_validation->set_rules('localidad', 'Localidad', 'required');
		$this->form_validation->set_rules('estatus', 'Estatus', 'required|callback_check_estatus');
		$this->form_validation->set_message('check_estatus', 'Tiene que seleccionar un status.');
		$this->form_validation->set_rules('area_profesional', 'Area profesional', 'required|callback_check_area');
		$this->form_validation->set_message('check_area', 'Seleccione un área profesional.');
		$this->form_validation->set_rules('iban', 'IBAN', 'required|callback_check_iban');
		$this->form_validation->set_message('check_iban', 'El IBAN no tiene formato valido.');


		$nombre = $this->input->post('nombre');
		$apellido1 = $this->input->post('apellido1');
		$apellido2 = $this->input->post('apellido2');

		$email = $this->input->post('email');

		$socio_data = array(
			'nombre' => $nombre,
			'apellido1' => $apellido1,
			'apellido2' => $apellido2,
			'dni' => $this->input->post('dni'),
			'email' => $email,
			'telefono' => $this->input->post('telefono'),
			'direccion' => $this->input->post('direccion'),
			'cp' => $this->input->post('cp'),
			'provincia' => $this->input->post('provincia'),
			'localidad' => $this->input->post('localidad'),
			'estatus' => $this->input->post('estatus'),
			'area_profesional' => $this->input->post('area_profesional'),
			'marca' => $this->input->post('marca'),
			'web' => $this->input->post('web'),
			'iban' => $this->input->post('iban'),
			'twitter' => $this->input->post('twitter'),
			'facebook' => $this->input->post('facebook'),
			'pinterest' => $this->input->post('pinterest'),
			'linkedin' => $this->input->post('linkedin'),
		);

		if ($socio_id != -1 ) {
			$socio_data['id'] = $socio_id;
		}

		//$data['socio_data'] = $socio_data;

		if ( $this->form_validation->run() == false ){
			$this->errors = $this->form_validation->error_array();
			$data['errors'] = $this->errors;
			$this->view($socio_id);
			return false;
		}

		if ( $socio_id == -1 ){
			$pass = $this->random_password();
			$usuario_data = array(
				'username' => $email,
				'password' => password_hash($pass, PASSWORD_DEFAULT)
			);
		} else {
			$usuario_data = array(
				'username' => $email,
			);
		}

		if ($this->Usuario_model->save_user($socio_data, $usuario_data, $socio_id)){
			if( $socio_id == -1 ) {
				$msg = 'Socio agregado con éxito: ' . $apellido1 . ' ' . $apellido2 .' '. $nombre;
				$this->flash->setMessage( $msg, $this->flash->getSuccessType() );

				$config = $this->Configuracion_model->get_configuracion();

				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => $this->encryption->decrypt($config->smtp),
					'smtp_port' => 465,
					'smtp_user' => $this->encryption->decrypt($config->email_emisor),
					'smtp_pass' => $this->encryption->decrypt($config->password),
					'mailtype' => 'html',
					'charset' => 'utf-8',
					'newline' => "\r\n"
				);

				$this->load->library('email', $config );
				$this->email->set_newline("\r\n");
				$this->email->from('no-reply@dip.com', 'DIP');

				$data = array(
					'name' => $socio_data['nombre']. ' ' . $socio_data['apellido1']. ' ' . $socio_data['apellido2'],
					'URL' => 'http://url',
					'user_name' => $socio_data['email'],
					'password' => $pass
				);

				$this->email->to($socio_data['email']);
				$this->email->subject('Alta en el sistema DIP');
				$message = $this->load->view('emails/new_user.php', $data, true);
				$this->email->message($message);
				$r = $this->email->send(false);

				if ( !$r ) {
					$msg = 'Error en el envio de email: ' . $this->email->print_debugger();
					$this->flash->setMessage( $msg, $this->flash->getErrorType());
				}
				$this->flash->setFlashMessages();

				redirect('socio/index');
			} else {
				$message_data = array(
					'item' => 'message',
					'type' => 'success',
					'message' => 'Socio modificado con éxito: ' . $apellido1 . ' ' . $apellido2 .' '. $nombre
				);
				$this->session->set_flashdata($message_data);
				redirect('socio/index');
			}
		} else {
			$message_data = array(
				'item' => 'message',
				'type' => 'danger',
				'message' => 'Error al agregar/actualizar socio: ' . $apellido1 . ' ' . $apellido2 .' '. $nombre
			);
			$this->session->set_flashdata($message_data);
			redirect('socio/index');
		}
	}

	public function delete( ) {
		$socio_to_delete = $this->input->post('id');

		$this->socio_model->delete($socio_to_delete);

	}


	/**
	 * Comprobamos que el campo provincia este seleccionado
	 */
	public function check_provincia($item){
		if ( $item == '' )
			return false;
		return true;
	}

	/**
	 * Comprobamos que el campo estatus está seleccionado
	 */
	public function check_estatus($item){
		if ( $item == '' )
			return false;
		return true;
	}

	/**
	 * Comprobamos que el campo area profesional está seleccionado
	 */
	public function check_area($item){
		if ( $item == '' )
			return false;
		return true;
	}

	/**
	 * Comprobamos la validez del iban
	 */
	public function check_iban($iban) {
		$iban = strtolower(str_replace(' ','',$iban));
		$Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
		$Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

		if(strlen($iban) == $Countries[substr($iban,0,2)]){

			$MovedChar = substr($iban, 4).substr($iban,0,4);
			$MovedCharArray = str_split($MovedChar);
			$NewString = "";

			foreach($MovedCharArray AS $key => $value){
				if(!is_numeric($MovedCharArray[$key])){
					$MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
				}
				$NewString .= $MovedCharArray[$key];
			}

			if(bcmod($NewString, '97') == 1)
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Genera un password aleatorio
	 */
	protected function random_password()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890#?|¿<>!¡';
		$password = array();
		$alpha_length = strlen($alphabet) - 1;
		for ($i = 0; $i < 10; $i++)
		{
			$n = rand(0, $alpha_length);
			$password[] = $alphabet[$n];
		}
		return implode($password);
	}
}