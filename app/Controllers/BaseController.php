<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function composePage($pageView, $arrData)
    {
        $session = session();
        if($session->has('session')) {
            $userData = $session->get('session');
            // echo "<hr><pre>";
            // print_r($userData);
            // echo "</pre><hr>";
            $arrData['arrPageData']['session'] = $userData;
            $arrData['arrHeadData']['session'] = $userData;
        }
        $arrData['arrHeadData']['JSConfig'] = [
            'BaseUrl' => base_url('/')
        ];
        return view('html_head', $arrData['arrHeadData'])
            . view('page_header', $arrData['arrPageData'])
            . view($pageView, $arrData['arrPageData'])
            . view('page_footer', $arrData['arrPageData'])
            . view('html_foot', $arrData['arrFootData']);
    }
}
