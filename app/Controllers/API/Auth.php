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
            $modelSession = model('App\Models\SessionModel');
            $activeSession = $modelSession->getActiveSessionByUserName($creds['sUserName']);
            if($activeSession==null) {
                $activeSession = $modelSession->createSession(
                    $creds['sUserName'],
                    $this->request->getUserAgent() . "|" . $this->request->getIpAddress()
                );
            }

			$session = session();

			$session->set('session', $activeSession);

			$respData['status'] = [
				'errcode' => 0,
				'message' => 'SUCCESS'
			];
			$respData['data'] = [
				'session' => $activeSession
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
        if($session->has('session')) {
            $sessionInfo = $session->get('session');
            $modelSession = model('App\Models\SessionModel');
            $activeSession = $modelSession->endSession($sessionInfo['uidPK']);
            $sessionInfo = $session->remove('session');
        }
		return redirect()->route('Home');
	}
}
