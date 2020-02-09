<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

class Configuracion extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index() {
		$this->load->view('configuracion/manage');
	}
}