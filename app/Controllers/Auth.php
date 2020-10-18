<?php

namespace App\Controllers;

use App\Model\Auth_Model;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->auth = new Auth_Model();
    }

	public function register()
	{
		$firstName = $this->request->getPost('first_name');
		$lastName = $this->request->getPost('last_name');
		$email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // generate password to hash
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        // mengelompokkan data dalam bentuk array
        $dataRregister = [
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'email'        => $email,
            'password'     => $password
        ];
        // insert data to table users
        $register = $this->auth->register($dataRregister);
        // jika hasil true 
        if($register){
            $output = [
                'status' => 200,
                'message' => 'Berhasil melakukan register'
            ];
            return $this->respond($output, 200)
        } else {
            $output = [
                'status' => 401,
                'message' => 'Gagal melakukan register'
            ];
            return $this->respond($output, 401)
        }
	}

}
