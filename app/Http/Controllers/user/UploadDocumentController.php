<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UploadDocumentController extends Controller
{
    public function index()
    {
        return View::make('userPanel.ajaxUploadFile');
    }
}
