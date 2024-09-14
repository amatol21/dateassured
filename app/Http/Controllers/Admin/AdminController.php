<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function home(): View
    {
        return view('admin.home');
    }

    public function payments(): View
    {
        return view('admin.payments');
    }

    public function setMaintenance(Request $request)
    {
        Config::setMaintenance(
            $request->post('to'),
            $request->post('message', 'Our service is temporary unavailable')
        );
    }
}
