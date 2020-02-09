<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Intranet extends CI_Controller {

	public function __construct(){
	  	parent::__construct();
	  	$this->load->helper('url');
		$this->load->library('encryption');
		$this->load->model('Usuario_model');
	}

   public function index(){
		$dataPage['titulo'] = 'Intranet';
		$dataPage['main_title'] = 'Intranet';
	   	$dataPage['description'] = 'Descripción de la página intranet.';
	   	$dataPage['keywords'] = 'intranet,palabras,clave';
	   	$this->load->view('componentes/header',$dataPage);
	   	$this->load->view('intranet');
	   	$this->load->view('componentes/footer');
   }
	/**
	* Cierra la sesion y sale de la pagina
	*/
   public function logout() {
	   $this->Usuario_model->logout();
   }
}