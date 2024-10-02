<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Requests\SaveProfileRequest;
use App\Models\Complaint;
use App\Models\User;
use App\Rules\Sentence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

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
		//dump($request);

		$photoFile = $request->file('photo');
		if ($photoFile !== null) {
			$user->setFromFile($photoFile);
		}

		$validated = $request->validate([
			'username' => ['required', 'max:32', 'alpha_dash'],
			'first_name' => ['required', 'max:32', 'alpha'],
			'second_name' => ['required', 'max:64', 'alpha'],
			'age' => ['numeric', 'min:18', 'max:100'],
			'nationality' => ['required', 'max:32', 'alpha'],
			'about' => ['max:512', new Sentence]
		]);

		$user->username = $request->post('username', $user->username);							// return post-method data 1 - param name, 
		$user->first_name = $request->post('first_name', $user->first_name);					//2 - value in case of absence
		$user->second_name = $request->post('second_name', $user->second_name);
		$user->age = intval($request->post('age', $user->age));
		$user->gender = Gender::from(intval($request->post('gender', $user->gender)));
		$user->nationality = $request->post('nationality', $user->nationality);
		$user->ethnicity = $request->post('ethnicity', $user->ethnicity);
		$user->religion = $request->post('religion', $user->religion);
		$user->languages = $request->post('languages', $user->languages);
		$user->body = $request->post('body', $user->body);
		$user->education = $request->post('education', $user->education);
		$user->occupation = $request->post('occupation', $user->occupation);
		$user->sexuality = $request->post('sexuality', $user->sexuality);
		$user->star_sign = $request->post('star_sign', $user->star_sign); 
		$user->relationship_status = $request->post('relationship_status', $user->relationship_status);
		$user->kids = $request->post('kids', $user->kids); 
		$user->about = $request->post('about', $user->about); 
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

	public function Search(Request $request): View|string
	{
		$users = User::orderBy('id', 'asc')->paginate(16);
		//dd($users);
		return view('account.search', compact('users'))
			->fragmentsIf($request->ajax(), ['meta', 'accountContent']);
	}
}
