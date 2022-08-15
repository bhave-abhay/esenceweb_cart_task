<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{

    use ResponseTrait;

    public function login()
    {
        $sUserName = $this->request->getPost('sUserName');
		$sPassHash = $this->request->getPost('sPassHash');

		$respData = array();
		if(
			($sUserName  ?? '') != '' &&
			($sPassHash  ?? '') != ''
		) {
			//Success
            $modelSession = model('App\Models\SessionModel');
            $activeSession = $modelSession->getActiveSessionByUserName($sUserName);
            if($activeSession==null) {
                $activeSession = $modelSession->createSession(
                    $sUserName,
                    $this->request->getUserAgent() . "|" . $this->request->getIpAddress()
                );
            }

			$session = session();

			$session->set('session', $activeSession);
            $respData = [
                'status' => 200,
                'error'    => null,
                'message' => 'SUCCESS',
                'data' => [
                    'session' => $activeSession
                ]
            ];
            return $this->respond($respData);
		}
        return $this->failUnauthorized('Failed to log in');
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
