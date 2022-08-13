<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        return view('html_head', ['sPageTitle'=>'Login'])
            .view('login')
            .view('html_foot', [
                'arrScript' => [
                    [
                        'src'=>"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js",
                        'integrity'=>"sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa",
                        'crossorigin'=>"anonymous"
                    ]
                ]
            ]);
    }
}