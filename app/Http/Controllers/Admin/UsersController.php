<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Enums\UserStatus;
use App\Filters\UsersFilter;
use App\Helpers\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BanUserRequest;
use App\Http\Requests\Admin\DeleteUserRequest;
use App\Http\Requests\Admin\ManageUserRequest;
use App\Http\Requests\Admin\SaveUserRequest;
use App\Http\Requests\FillUpBalanceRequest;
use App\Models\User;
use App\Rules\Sentence;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
	public function index(Request $request): View
	{
		return view('admin.users.list', [
			'users' => UsersFilter::createQuery($request)->paginate(10),
		]);
	}

	public function editForm(Request $request, int $id): View
	{
		$user = User::where('id', $id)->first();
		if ($user === null) abort(404);
		return view('admin.users.form', ['user' => $user]);
	}

	public function creationForm (): View
	{
		return view('admin.users.form', ['user' => new User()]);
	}

	public function save(SaveUserRequest $request): RedirectResponse
	{
		$user = $request->has('id')
			? User::where('id', $request->post('id'))->first()
			: new User();
		if ($user === null) abort(404);

		$photoFile = $request->file('photo');
		if ($photoFile !== null) {
			$user->setFromFile($photoFile);
		}

		$validated = $request->validate([
			'username' => ['required', 'max:32', 'alpha_dash'],
			'email' => ['required', 'email'],
			'first_name' => ['required', 'max:32', 'alpha'],
			'second_name' => ['required', 'max:64', 'alpha'],
			'age' => ['numeric', 'min:18', 'max:100'],
			'country' => ['required', 'max:32', 'alpha'],
			'about' => ['max:512', new Sentence]
		]);

		$user->username = $request->username;
		$user->email = $request->email;
		$user->first_name = $request->first_name;
		$user->second_name = $request->second_name;
		$user->age = $request->age;
		$user->sexuality = $request->sexuality;
		$user->gender = $request->gender;
		$user->country = $request->country;
		$user->ethnicity = $request->ethnicity;
		$user->religion = $request->religion;
		$user->languages = $request->languages;
		$user->body = $request->body;
		$user->education = $request->education;
		$user->occupation = $request->occupation;
		$user->star_sign = $request->star_sign; 
		$user->relationship_status = $request->relationship_status;
		$user->kids = $request->kids; 
		$user->about = $request->about; 

		if (User::current()->hasPermission(Permission::MANAGE_ROLES)) {
			$user->role_id = $request->role_id;
		}
		if ($request->has('password') && !empty($request->password)) {
			$user->password = Hash::make($request->password);
		}
		if ($user->save()) {
			Toast::success($request->has('id')
					? 'User saved successfully'
					: 'User created successfully');
		}
		return redirect()->route('admin.users');
	}

	public function verifyEmail(ManageUserRequest $request): string
	{
		$success = DB::table('users')
			->where('id', '=', $request->id)
			->update([
					'email_verified_at' => DB::raw('NOW()'),
			]) > 0;
		if ($success) {
			Toast::success('Email successfully verified');
		} else {
			Toast::error('Error occurred during processing your request');
		}
		return response('OK', 200);
	}

	public function delete(DeleteUserRequest $request): string
	{
		$user = User::where('id', $request->id)->first();
		if ($user !== null) {
			$user->status = UserStatus::DELETED;
			$user->save();
		}
		return response('OK', 200);
	}

	public function ban(BanUserRequest $request): string
	{
		$success = DB::table('users')
			->where('id', '=', $request->id)
			->update([
					'status' => UserStatus::BANNED,
					'banned_to' => DB::raw('NOW() + interval ' . $request->days . ' day'),
			]) > 0;
		if ($success) {
			Toast::success('User has been banned');
		} else {
			Toast::error('Error occurred during processing your request');
		}
		return response('OK', 200);
	}

	public function unban(ManageUserRequest $request): string
	{
		$success = DB::table('users')
			->where('id', '=', $request->id)
			->update([
					'status' => UserStatus::ACTIVE,
					'banned_to' => null,
			]) > 0;
		if ($success) {
			Toast::success('User is no longer banned');
		} else {
			Toast::error('Error occurred during processing your request');
		}
		return response('OK', 200);
	}

	public function fillUpBalance(FillUpBalanceRequest $request): Response
	{
		/** @var User $user */
		$user = User::where('id', $request->id)->first();
		if ($user === null) abort(404);
		$user->money += floatval(str_replace(',', '.', $request->count)) * 1000;
		$user->save();
		Toast::success("Balance was successfully filled up for user " . $user->getFullName());
		return response('OK', 200);
	}
}
