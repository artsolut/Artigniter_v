<?php if (!defined('BASEPATH')) {die('Direct access not permited.');}  

class Flash {

	const INFO_MESSAGE_TYPE = 'info';
	const SUCCESS_MESSAGE_TYPE = 'success';
	const ERROR_MESSAGE_TYPE = 'danger';

	private  $CI;

	private $flashMessages = array();

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
	}

	public function getErrorType() {
		return self::ERROR_MESSAGE_TYPE;
	} 

	public function getInfoType() {
		return self::INFO_MESSAGE_TYPE;
	}

	public function getSuccessType() {
		return self::SUCCESS_MESSAGE_TYPE;
	}

	public function setMessage($message, $messageType)
	{
		if ($messageType && $message) {
			$this->flashMessages[$messageType][] = $message;
		}
	}

	public function setFlashMessages() {
		$this->CI->session->set_flashdata('flash_messages', $this->flashMessages);

	}
}