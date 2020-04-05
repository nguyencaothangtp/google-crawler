<?php

namespace App\Http\Controllers;

use App\Exceptions\FileException;
use App\Helpers\Helper;
use App\Jobs\CrawlSiteJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return mixed
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

        // Send to Worker to process background jobs
        $filePath = storage_path('csv') . '/' . $file->getClientOriginalName();
        $this->dispatch(new CrawlSiteJob($filePath));

        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => __('File was imported successfully and being processed')
        ]);
    }

}
