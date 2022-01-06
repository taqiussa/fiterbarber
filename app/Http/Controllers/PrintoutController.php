<?php

namespace App\Http\Controllers;

use App\Models\Printout;


class PrintoutController extends Controller
{
    public function index()
    {
        return view('pages.printout.printout-data', [
            'printout' => Printout::class
        ]);
    }
    public function toprintout()
    {
        return view('pages.toprintout.toprintout-data');
    }
}
