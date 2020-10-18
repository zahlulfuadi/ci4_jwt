<?php namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Controllers\Auth;
use CodeIgniter\RESTful\ResourceController;

// header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Header: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class Home extends ResourceController
{
	public function __construct()
	{
		$this->protect = new Auth();
	}

	public function index()
	{
		// ambil secret key dari controller auth 
		$secret_key = $this->protect->privateKey();

		$token = null;

		$authHeader = $this->request->getServer('HTTP_AUTHORIZATION');

		$arr = explode(" ", $authHeader);

		$token = $arr[1];

		if($token){
			try{
				$decode = JWT::decode($token, $secret_key, array('HS256'));

				// pengecekan jika telah dideskripsi
				if($decode){
					// halaman akses
					// crud mengelola database
					$output = [
						'message'	=> 'Access granted'
					];
					return $this->respond($output, 200);
				}
			} catch(\Exception $e){
				// kalau token salah atau expired

				$output = [
					'message'	=> 'Access denied',
					'error'		=> $e->getMessage()
				];
				return $this->respond($output, 401);
			}
		}
	}

	//--------------------------------------------------------------------

}
