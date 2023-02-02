<?php

namespace App\Presentation\Controllers;

use App\Core\BaseController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends BaseController
{
    /**
     * Example action with sample data.
     *
     * @param Request $request
     * @param array $params
     */
    public function index(Request $request, array $params = [])
    {
        $context = [
            'title' => 'Fancy blog title',
            'description' => 'Fancy blog description',
            'date' => mktime(0, 0, 0, $params['month'], $params['day'], $params['year']),
        ];

        $this->view->show('blog.html.twig', $context);
    }
}
