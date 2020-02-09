<?php
class Login_model extends CI_model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function login($email, $password)
    {
        $query = $this->db->get_where('socios', array('email' => $email));
        if($query->num_rows() == 1)
        {
            $row=$query->row();
            if($password==$row->password)
            {
                $data=array('user_data'=>array (
                    'id'=>$row->id,
                    'email'=>$row->email,
					'password'=>$row->password,
					'nombre' => $row->nombre,
					'apellido1' => $row->apellido1,
					'apellido2' => $row->apellido2,
				));
                $this->session->set_userdata($data);
                return true;
            }
        }
        $this->session->unset_userdata('user_data');
        return false;
    }
}