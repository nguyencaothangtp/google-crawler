<?php

namespace App\Http\Controllers;

use App\Exceptions\FileException;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * The allowed file types.
     *
     * @var array
     */
    public $allowTypes = ['csv'];

    /**
     * The request instance.
     *
     * @var Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Upload file.
     *
     * @return void
     */
    public function create()
    {
        if (!$this->request->hasFile('keywords')) {
            throw FileException::notFound();
        }

        $file = $this->request->file('keywords');
        if (!in_array($file->getClientOriginalExtension(), $this->allowTypes)) {
            throw FileException::notSupportedExtension();
        }

        $file->move(storage_path('csv'), $file->getClientOriginalName());
    }

}
