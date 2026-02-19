<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PanelController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('panel.home', compact('user'));
    }
}
