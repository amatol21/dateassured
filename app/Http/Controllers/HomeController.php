<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Models\ContactUsMessage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
    }

    public function contactUs(ContactUsRequest $request): View
    {
        $message = new ContactUsMessage();
        $message->name = $request->post('name');
        $message->email = $request->post('email');
        $message->subject = $request->post('subject');
        $message->message = $request->post('message');
        $message->save();
        return view('contactUs.successMessage');
    }
}
