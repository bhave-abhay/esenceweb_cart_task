<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
		$creds = $this->request->getPost();
		$respData = array();
		if(
			($creds['sUserName'] ?? '') != '' &&
			($creds['sPassHash'] ?? '') != ''
		) {
			//Success

			$session = session();

			$session->set('user', $creds);

			$respData['status'] = [
				'errcode' => 0,
				'message' => 'SUCCESS'
			];
			$respData['data'] = [
				'sUserName' => $creds['sUserName']
			];
		}
		else {
			//Failure
			$respData['status'] = [
				'errcode' => 1000,
				'message' => 'Login failed'
			];
		}
        return $this->response->setJSON($respData);
    }

	public function logout()
	{
		$session = session();
		$session->remove('user');
		return redirect()->route('Home');
	}
}
