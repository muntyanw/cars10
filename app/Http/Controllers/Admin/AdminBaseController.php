<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBaseController extends Controller
{
    public function __construct(Request $request)
    {
        // if (!auth()->check()) {
        //     session(['return_url' => $request->fullUrl()]);
        //     return redirect("/login");
        //  }
    }

}
