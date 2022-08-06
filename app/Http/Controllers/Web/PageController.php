<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller {

    public function index(Request $request)
    {
        return view('web.index');
    }
}
