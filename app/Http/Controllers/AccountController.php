<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Requests\SaveProfileRequest;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View|string
    {
        return view('account.videoSessions')
            ->fragmentsIf($request->ajax(), ['meta', 'accountContent']);
    }

    public function profile(Request $request): View|string
    {
        return view('account.profile')
            ->fragmentsIf($request->ajax(), ['meta', 'accountContent']);
    }

    public function contacts(Request $request): View|string
    {
        return view('account.contacts')
            ->fragmentsIf($request->ajax(), ['meta', 'accountContent']);
    }

    public function matches(Request $request): View|string
    {
        return view('account.matches')
            ->fragmentsIf($request->ajax(), ['meta', 'accountContent']);
    }

    public function wallet(Request $request): View|string
    {
        return view('account.wallet')
            ->fragmentsIf($request->ajax(), ['meta', 'accountContent']);
    }

    public function saveProfile(SaveProfileRequest $request): string
    {
        /** @var User $user */
        $user = Auth::user();

        $photoFile = $request->file('photo');
        if ($photoFile !== null) {
            $user->setFromFile($photoFile);
        }

        $user->username = $request->post('username', $user->username);
        $user->first_name = $request->post('first_name', $user->second_name);
        $user->second_name = $request->post('second_name', $user->second_name);
        $user->age = intval($request->post('age', $user->age));
        $user->gender = Gender::from(intval($request->post('gender', $user->gender)));
        $user->save();

        return $request->ajax()
            ? view('account.profile')->fragment('content')
            : redirect()->route('account.profile');
    }

    public function complaintDetails(Request $request, $id): View
    {
        /** @var Complaint $complaint */
        $complaint = Complaint::where('id', $id)->first();
        if ($complaint === null || $complaint->creator_id != Auth::id()) abort(404);
        return view('account.complaint', ['complaint' => $complaint]);
    }
}
