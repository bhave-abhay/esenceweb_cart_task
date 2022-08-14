<?php

namespace App\Controllers;

class Cart extends BaseController
{
    public function index()
    {
        // TODO: FILTER??
        {
            $session = session();
            if(!$session->has('session')) {
                return redirect()->to('/Home');
            }
            $sessionInfo = $session->get('session');
            $modelSession = model('App\Models\SessionModel');
            $activeSession = $modelSession->getActiveSessionByID($sessionInfo['uidPK']); // TODO: (uid, salt) ---> suid

            if($activeSession==null) {
                return redirect()->to('/Home');
            }
        }
        return $this->composePage(
            'cart',
            [
                'arrHeadData' => [
                    'sPageTitle' => 'CodeIgniter Sample Page'
                ],
                'arrPageData' => [
                    'sNavLink' => 'Cart', //Not actually on NAV
                    'userData' => $activeSession ?? "NULL"
                ],
                'arrFootData' => [
                    'arrScript' => [
                        [
                            'src'=>"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js",
                            'integrity'=>"sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa",
                            'crossorigin'=>"anonymous"
                        ]
                    ]
                ]
            ]
        );
    }
}
