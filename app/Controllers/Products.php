<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function index()
    {
        return $this->composePage(
            'product_list',
            [
                'arrHeadData' => [
                    'sPageTitle' => 'CodeIgniter Sample Page'
                ],
                'arrPageData' => [
                    'sNavLink' => 'Products',
                ],
                'arrFootData' => [
                    'arrScript' => [
                        [
                            'src'=>"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js",
                            'integrity'=>"sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa",
                            'crossorigin'=>"anonymous"
                        ],
                        [
                            'src' => "https://code.jquery.com/jquery-3.6.0.min.js",
                            'integrity' => "sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=",
                            'crossorigin' => "anonymous"
                        ]
                    ]
                ]
            ]
        );
    }
}
