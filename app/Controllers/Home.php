<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return $this->composePage(
            'welcome_message',
            [
                'arrHeadData' => [
                    'sPageTitle' => 'CodeIgniter Sample Page'
                ],
                'arrPageData' => [
                    'sNavLink' => 'Home',
                    'sData1' => 'Abhay'
                ],
                'arrFootData' => [
                    'arrScript' => [
                        [
                            'src'=>"Resources/bootstrap-5.2.0-dist/js/bootstrap.bundle.min.js",
                            'integrity'=>"sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa",
                            'crossorigin'=>"anonymous"
                        ],
                        [
                            'src' => "Resources/jquery-3.6.0-dist/jquery-3.6.0.min.js",
                            'integrity' => "sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=",
                            'crossorigin' => "anonymous"
                        ]
                    ]
                ]
            ]
        );
    }
}
