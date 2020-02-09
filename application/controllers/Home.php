<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller { 
   
	public function __construct(){
        parent::__construct(); 
        $this->load->helper('url'); 
		$this->load->library('encryption');
    }
   
   
   public function index(){	   
	   $dataPage['titulo'] = 'Inicio';
	   $dataPage['description'] = 'Descripción de la página de inicio.';
	   $dataPage['keywords'] = 'inicio,palabras,clave';
	   $this->load->view('componentes/header',$dataPage);
	   $this->load->view('home'); 
	   $this->load->view('componentes/footer');    
	    
   }
}