<?php

namespace App\Presentation\Controllers;

use App\Core\BaseController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends BaseController
{
    /**
     * Main page index sample.
     *
     * @param Request $request
     * @param array $params
     */
    public function index(Request $request, array $params = [])
    {
        $this->view->show('index.html.twig');
    }
}
