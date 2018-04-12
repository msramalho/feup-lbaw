<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Shows the index page.
     *
     * @return Response
     */
    public function show()
    {
      return view('pages.index');
    }
}
