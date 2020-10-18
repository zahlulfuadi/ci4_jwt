<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;

class Auth extends ResourceController
{
    public function __construct()
    {
        $this->auth = new Auth_Model();
    }

    public function privateKey()
    {
        $privateKey = <<<EOD
            -----BEGIN RSA PRIVATE KEY-----
            MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
            vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
            5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
            AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
            bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
            Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
            cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
            5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
            ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
            k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
            qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
            eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
            B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
            -----END RSA PRIVATE KEY-----
            EOD;

            return $privateKey;
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // cek login 
        $cek_login = $this->auth->cek_login($email);

        if(password_verify($password, $cek_login['password'])) {
            // sukses login 
            // konfigurasi token
            $secret_key = $this->privateKey();
            $issuer_claim = "THE_CLAIM";
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time();
            $notbefore_claim = $issuedat_claim + 10;
            $expire_claim = $issuedat_claim + 3600;

            $token = [
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => [
                    'id' => $cek_login['id'],
                    'first_name' => $cek_login['first_name'],
                    'last_name' => $cek_login['last_name'],
                    'email' => $cek_login['email'],
                    'password' => $cek_login['password']
                ]
            ];

            // generate token 
            $token = JWT::encode($token, $secret_key);
            // jika berhasil
            $output = [
                'status'    => 200,
                'message'   => 'Login sucessfully',
                'token'     => $token,
                'expireAt'  => $expire_claim
            ];
            return $this->respond($output, 200);
        } else {
            // gagal login
            $output = [
                'status'    => 401,
                'message'   => 'Login failed'
            ];
            return $this->respond($output, 401);
        }
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
        $dataRegister = [
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'email'        => $email,
            'password'     => $password_hash
        ];
        // insert data to table users
        $register = $this->auth->register($dataRegister);
         
        if($register){
            // jika hasil true
            $output = [
                'status' => 200,
                'message' => 'Berhasil melakukan register'
            ];
            return $this->respond($output, 200);
        } else {
            // jika hasil false
            $output = [
                'status' => 401,
                'message' => 'Gagal melakukan register'
            ];
            return $this->respond($output, 401);
        }
	}

}
