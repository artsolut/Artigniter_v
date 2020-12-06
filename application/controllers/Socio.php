<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

/**
* Clase Socio. 
* Gestiona la lógica de la sección de socios
**/
class Socio extends CI_Controller {

    public function __construct() {
        //Precargas no realizadas en autoload
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->model('Socio_model');
		$this->load->model('Configuracion_model');
		$this->load->model('Area_model');
        $this->load->model('Estatus_model');
        $this->load->model('Provincia_model');        
		//$this->load->helper('url', 'form');
		//$this->load->library('form_validation');
		//$this->errors = array();
    }

    /**
    * Método Index (método por defecto configurado en routes)
    * Método para cargar listado de socios y vista del listado, generando variables generales
    * Parámetros: 
    * Return: 
    */
    public function index() {

		//Si no hay sesión activa redirigimos a login
        if ( !$this->Usuario_model->is_logged_in() ){
            
            redirect('login');
        
        }
			
        if ($this->usuario_model->check_access(2)){
            
            //Si la sesión está activa y el nivel de acceso es el adecuado cargamos listado de socios
            $socios_obj = $this->Socio_model->get_all();

            // variable de información general
            $data['nestedview']['main_title'] = 'Listado de Socios';
            // objeto con listado de socios
            $data['socios_data'] = $socios_obj;

            // añadimos ruta al camino de migas
            $this->mybreadcrumb->add( 'Socios', 'socios' );

            // Generamos el camino de hormigas y lo añadimos al objeto nestedview
            $data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

            // Cargamos vista para mostrar el listado de socios
            //$this->session->keep_flashdata();
            $this->load->view('socios/listado', $data );
            
        }elseif ($this->usuario_model->check_access(3)){
            //Si el nivel de acceso es solo socio cargamos su ficha
            redirect('socio/socio_view/'.$this->session->id_socio);
        }
	}

    /**
    * Método View 
    * Método para editar el registro de un socio
    * Parámetros: id de socio
    * Return: 
    */
	public function view($socio_id = -1 ) {
        //
		$socio_info = $this->socio_model->get_info($socio_id);

		foreach (get_object_vars($socio_info) as $property => $value) {
			$socio_info->$property = $value;
		}

		$data["socio_data"] = $socio_info;
		$data['main_title'] = '';

		$this->mybreadcrumb->add('Socios', 'socios');
        
        if ($socio_id == - 1){
            $this->mybreadcrumb->add('Nuevo socio', 'socios/edit');
        }else{
            $this->mybreadcrumb->add('Editar socio', 'socios/edit');
        }

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$data['errors'] = $this->errors;

		$this->load->view('socios/form', $data);
	}

    /**
    * Método Socio_view 
    * Método para visualizar el registro de un socio (sólo para ese socio)
    * Parámetros: id de socio
    * Return: 
    */
	public function socio_view($socio_id = -1 ) {
        //
		$socio_info = $this->socio_model->get_info($socio_id);

		foreach (get_object_vars($socio_info) as $property => $value) {
			$socio_info->$property = $value;
		}

		$data["socio_data"] = $socio_info;
		$data['main_title'] = '';

		$this->mybreadcrumb->add('Socios', 'socios');
		$this->mybreadcrumb->add('Ficha de registro', 'socios/socio_view');

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$data['errors'] = $this->errors;

		$this->load->view('socios/socio_card', $data);
	}
    

    /**
    * Método Save 
    * Método para guardar el registro de un socio
    * Parámetros: id de socio (si es edición o -1 si es nuevo)
    * Return: boolean
    */
	public function save( $socio_id = -1 ) {

        //Validación de formulario
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('apellido1', 'Primer apellido', 'trim|required');
		$this->form_validation->set_rules('apellido2', 'Segundo apellido', 'trim|required');
        $this->form_validation->set_rules('fecha_alta', 'Fecha de alta', 'required|callback_check_fecha_alta');
        $this->form_validation->set_message('check_fecha_alta', 'Formato erróneo. Deber ser año(4)-mes(2)-día(2).');
        

		if ( $socio_id == -1 ) {
			$this->form_validation->set_rules('dni', 'DNI', 'trim|required|is_unique[socio.dni]');
		} else
			$this->form_validation->set_rules('dni', 'DNI', 'trim|required');

		$this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');
		$this->form_validation->set_rules('cp', 'Código postal', 'required|is_numeric|exact_length[5]');

		if($socio_id == -1 )
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[socio.email]');
		else
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		$this->form_validation->set_rules('telefono', 'Teléfono', 'required|is_numeric|min_length[9]');
		$this->form_validation->set_rules('provincia', 'Provincia', 'required|callback_check_provincia');
		$this->form_validation->set_message('check_provincia', 'Selecciona una provincia.');
		$this->form_validation->set_rules('localidad', 'Localidad', 'required');
		$this->form_validation->set_rules('estatus', 'Estatus', 'required|callback_check_estatus');
		$this->form_validation->set_message('check_estatus', 'Tienes que seleccionar un status.');
		$this->form_validation->set_rules('area_profesional', 'Area profesional', 'required|callback_check_area');
		$this->form_validation->set_message('check_area', 'Selecciona un área profesional.');
		$this->form_validation->set_rules('iban', 'IBAN', 'required|callback_check_iban');
		$this->form_validation->set_message('check_iban', 'El IBAN no tiene formato valido.');
        $this->form_validation->set_rules('nivel', 'Nivel de Acceso', 'required');
        
        $this->form_validation->set_rules('twitter', 'TWITTER', 'valid_url');
        $this->form_validation->set_rules('facebook', 'FACEBOOK', 'valid_url');
        $this->form_validation->set_rules('instagram', 'INSTAGRAM', 'valid_url');
        $this->form_validation->set_rules('linkedin', 'LINKEDIN', 'valid_url');


        //Generamos el array socio_data con todos los campos
		$nombre = $this->input->post('nombre');
		$apellido1 = $this->input->post('apellido1');
		$apellido2 = $this->input->post('apellido2');

		$email = $this->input->post('email');
        $nivel = $this->input->post('nivel');
        
        //Subimos los archivos 
        $images = $this->upload_images();
        
		$socio_data = array(
			'nombre' => $nombre,
			'apellido1' => $apellido1,
			'apellido2' => $apellido2,
            'apellido2' => $apellido2,
            'fecha_alta' => $this->input->post('fecha_alta'),
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
            'logo_marca' => $images['logo_marca'],
            'foto' => $images['foto'],
			'iban' => $this->input->post('iban'),
			'twitter' => $this->input->post('twitter'),
			'facebook' => $this->input->post('facebook'),
			'instagram' => $this->input->post('instagram'),
			'linkedin' => $this->input->post('linkedin'),
            'otros' => $this->input->post('otros'),
            'notas' => $this->input->post('notas')
            
		);
        

        

		if ($socio_id != -1 ) {
			$socio_data['id'] = $socio_id;
            
            //Eliminamos del array $socio_data los campos de imagen que no hayan sido modificados (pues vienen vacíos)
            if ($socio_data['logo_marca'] === null)
                unset($socio_data['logo_marca']);
            if ($socio_data['foto'] === null)
                unset($socio_data['foto']);
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
				'password' => password_hash($pass, PASSWORD_DEFAULT),
                'nivel'    => $nivel
			);
            
		} else {
			$usuario_data = array(
				'username' => $email,
                'nivel' => $nivel
			);
		}

		if ($this->Usuario_model->save_user($socio_data, $usuario_data, $socio_id)){
			if( $socio_id == -1 ) {
                
                $message_data = array(
				'item' => 'message',
				'type' => 'success',
				'message' => 'Socio agregado con éxito: ' . $apellido1 . ' ' . $apellido2 .' '. $nombre
			     );
			     $this->session->set_flashdata($message_data);
                
                
                /////////////////////////
                
                $message_recovery = "Hola. Si has solicitado la recuperación de la contraseña, haz clic en <strong><a href='". $url_recovery ."'>este enlace</a></strong> para iniciar el proceso, en caso contrario elimina este correo.";


                            

                           
                
                ////////////////////////
                


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
                
                $data = array(
					'name' => $socio_data['nombre']. ' ' . $socio_data['apellido1']. ' ' . $socio_data['apellido2'],
					'URL' => 'https://socios.dipmurcia.es',
					'user_name' => $socio_data['email'],
					'password' => $pass
				);
                
                $this->load->library('email');
                $this->email->initialize($config);
                $this->email->from($config['smtp_user'], 'Dip');


                $this->email->to($socio_data['email']);
                $this->email->subject('Alta como socio en el sistema DIP');
                $message = $this->load->view('emails/new_user.php', $data, true);
                $this->email->message($message);


                if ($this->email->send(FALSE)){

                    //$this->session->set_flashdata("success", "Se ha enviado un correo a la dirección de e-mail facilitada.");
                    //$this->load->view('login/reset_password', "refresh");

                }else{

                    //si ocurre algún error en el envío mostramos lista de errores.
                    //show_error($this->email->print_debugger());
                    $msg = 'Error en el envio de email: ' . $this->email->print_debugger();
					$this->flash->setMessage( $msg, $this->flash->getErrorType());
                    $message_data = array(
                        'item' => 'message',
                        'type' => 'danger',
                        'message' => $msg
                     );
                     $this->session->set_flashdata($message_data);
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

  /**
    * Método upload_images 
    * Método para subir el logo y la foto de los socixs
    * Return: datos imágenes
    */  
    
    public function upload_images()
    {
            $configupload['upload_path']          = './public/images/logos/';
            $configupload['allowed_types']        = 'gif|jpg|png';
            $configupload['max_size']             = 1024;
            $configupload['max_width']            = 800;
            $configupload['max_height']           = 800;

            $this->load->library('upload', $configupload);
            $this->load->library('session');
            $this->load->helper('security');

            if ( $this->security->xss_clean($this->upload->data(), TRUE) === FALSE )
            {

                $message_data = array(
					'item' => 'message',
					'type' => 'errormsg',
					'message' => 'Error xss archivo'
				);
				$this->session->set_flashdata($message_data);
                rediret("socio/view", "refresh");

            }

            if (!$this->upload->do_upload("foto"))
            {
                $message_data = array(
					'item' => 'message',
					'type' => 'errormsg',
					'message' => $this->upload->display_errors()
				);
				$this->session->set_flashdata($message_data);  
            }
            else
            {
                $message_data = array(
					'item' => 'message',
					'type' => 'success',
					'message' => $this->upload->data()
				);
				$this->session->set_flashdata($message_data);  
                $files['foto'] =  $this->upload->data('file_name');
            }

            if (!$this->upload->do_upload("logo"))
            {
                $message_data = array(
					'item' => 'message',
					'type' => 'errormsg',
					'message' => $message_data['message']. " - ".$this->upload->display_errors()
				);
				$this->session->set_flashdata($message_data);  
            }
            else
            {
                
                $message_data = array(
					'item' => 'message',
					'type' => 'success',
					'message' => $message_data['message']." - ".$this->upload->data()
				);
				$this->session->set_flashdata($message_data);  
                $files['logo_marca'] = $this->upload->data('file_name');

            }

            return $files;
    }
        
    
  /**
    * Método delete_socio 
    * Método para marcar como eliminados a socios desde el listado de socios. No borra, solo marca.
    * Parámetros: $socio_to_delete (id de socio)
    * Return: redirige a socio/index con un mensaje de éxito o de error
    */  
	public function delete_socio( $socio_to_delete ) {
        
        if ($this->socio_model->exists($socio_to_delete)){
            
            $this->socio_model->delete_item($socio_to_delete);
            
             $message_data = array(
                'item' => 'message',
                'type' => 'success',
                'message' => 'Ha sido borrado con éxito el socio ' . $socio_to_delete,
             );
            
            $this->session->set_flashdata($message_data);
			
            redirect('socio/index');    
                                                          
        }else{

            $message_data = array(
                'item' => 'message',
                'type' => 'danger',
                'message' => 'Ha ocurrido un error al eliminar el socio ' . $socio_to_delete,
             );
            $this->session->set_flashdata($message_data);
            
            redirect('socio/index');   

        }

	}


    /**
    * Método export_excel 
    * Método para exportar a Excel el listado completo de socios.
    * Parámetros: $socio_to_delete (id de socio)
    * Return: redirige a socio/index con un mensaje de éxito o de error
    */  
	public function export_excel() {
        
        if ($this->usuario_model->check_access(2)){
            
            //Si la sesión está activa y el nivel de acceso es el adecuado cargamos listado de socios
            $socios_obj = $this->Socio_model->get_all();

            $data['socios_data'] = $socios_obj;
            
           
            $timestamp = time();
            $filename = 'Socios_Dip_' . $timestamp . '.xls';
            
            header("Content-Type: application/vnd.ms-excel; charset:utf-8" ); 
            header("Content-Disposition: attachment; filename=\"$filename\"");
            echo "<table>";
                echo "<tr>";
                    echo "<th>Nombre";
                    echo "</th";
                    echo "<th>Email";
                    echo "</th";
                    echo "<th>Teléfonos";
                    echo "</th";
                    echo "<th>Estatus";
                    echo "</th";
                    echo "<th>Localidad";
                    echo "</th";
                    echo "<th>Área Profesional";
                    echo "</th";       
                echo "</tr>";

                foreach ( $data['socios_data']->result() as $socio ):

                    $nombre = $socio->apellido1.' '.$socio->apellido2.', '.$socio->nombre;

                    echo "<tr>";
                        echo "<td>".$nombre;
                        echo "</td";
                        echo "<td>". $socio->email;
                        echo "</td";
                        echo "<td>". $socio->telefono;
                        echo "</td";
                        echo "<td>".$this->Estatus_model->get_estatus($socio->estatus);
                        echo "</td";
                        echo "<td>". $socio->localidad ;
                        echo "</td";
                        echo "<td>". $this->Area_model->get_area($socio->area_profesional);
                        echo "</td";       
                    echo "</tr>";

                endforeach;

            echo "</table>";
            
            // Cargamos vista para mostrar el listado de socios
            //$this->session->keep_flashdata();
            $this->load->view('socios/listado', $data );
            
        }elseif ($this->usuario_model->check_access(3)){
            //Si el nivel de acceso es solo socio cargamos su ficha
            redirect('socio/socio_view/'.$this->session->id_socio);
        }

	}
    
    
    /**
    * Función encargada de exportar a excel.
    * Recibe como parametro un arreglo de datos.
    *---------------------------------------------------------------*/

    public function export_socios($data) {
        
        
    }    
    
    
    
	/**
	 * Comprobamos que el campo provincia este seleccionado
	 */
	public function check_provincia($item){
		if ( $item == '' )
			return false;
		return true;
	}
	public function check_fecha_alta($item){
		
        $anno = (int) substr($item,0,4);
        $mes = (int) substr($item,5,2);
        $dia = (int) substr($item,8,2);
        
        
        if ( trim($item) == '' || $item == "0000-00-00")
            return false;
        
        if ($dia > 31 || $dia < 1 || $mes > 12 || $mes < 1 || $anno > (int) date("Y") || $anno < 1940)
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