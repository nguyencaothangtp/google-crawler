<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
}
