<?php

namespace App\Controllers;

class Cart extends BaseController
{
    public function index()
    {
        $session = session();
        if(!$session->has('user')) {
            return redirect()->to('/Home');
        }

        return $this->composePage(
            'cart',
            [
                'arrHeadData' => [
                    'sPageTitle' => 'CodeIgniter Sample Page'
                ],
                'arrPageData' => [
                    'sNavLink' => 'Cart', //Not actually on NAV
                    'userData' => $session->get('user')
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
