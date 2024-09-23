<?php

use App\Enums\Permission;
use App\Enums\Sexuality;
use App\Models\Role;
use App\Models\User;
use App\Enums\Gender;
use App\Enums\Size;
use App\Enums\StarSign;
use App\Enums\RelationshipStatus;
use App\Enums\Kids;
use App\Enums\Ethnicity;
use App\Enums\Religion;
use App\Enums\Languages;
use App\Enums\Body;
use App\Enums\Education;
use App\Enums\Occupation;

$ethnicity_arr = Ethnicity::cases();
$religion_arr = Religion::cases();
$languages_arr = Languages::cases();
$body_arr = Body::cases();
$education_arr = Education::cases();
$occupation_arr = Occupation::cases();
$sexuality_arr = Sexuality::cases();
$star_sign_arr = StarSign::cases();
$relationship_status_arr = RelationshipStatus::cases();
$kids_arr = Kids::cases();

//dump($user);


/**
 * @var User $user
 */
?>

@extends('admin.index')

@section('adminContent')
	<div class="admin_right-container pad">
		<h2 class="account_title">
			<a href="{{ route('admin.users', [], false) }}" class="admin_back-button">Users</a>
			<span>{{ $user->exists ? $user->getFullName() : 'User creation' }}</span>
		</h2>

		<form action="{{ route('admin.users.save', [], false) }}" class="profile_form" method="POST" enctype="multipart/form-data">
			@csrf

			

			@if($user->exists)
				<input type="hidden" name="id" value="{{ $user->id }}">
			@endif

			@include('common.ui.photoInput', ['value' => $user->getPhotoUrl(Size::LARGE)])

			<div class="profile_fields">

				<label>
						<span class="label">Username</span>
						<input type="text" name="username" class="input" value="{{ old('username', $user->username) }}">
						@error('username')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Email</span>
						<input type="email" name="email" class="input" value="{{ old('email', $user->email) }}">
						@error('email')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Gender</span>
						<select name="gender" class="select">
							<option value="{{ Gender::MALE->value }}"
										@if(old('gender', $user->gender) === Gender::MALE) selected @endif>
								Male
							</option>
							<option value="{{ Gender::FEMALE->value }}"
										@if(old('gender', $user->gender) === Gender::FEMALE) selected @endif>Female
							</option>
						</select>
						@error('gender')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Sexuality</span>
						<select name="sexuality" class="select">
							@foreach(Sexuality::cases() as $sexuality)
								<option value="{{ $sexuality->value }}"
									@if(old('sexuality', $user->sexuality) === $sexuality) selected @endif>
									{{ __('enums.sexuality.'.$sexuality->value) }}
								</option>
							@endforeach
						</select>
						@error('sexuality')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Age</span>
						<input type="number" name="age" min="18" max="80" class="input" value="{{ old('age', $user->age) }}">
						@error('age')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">First name</span>
						<input type="text" name="first_name" class="input" value="{{ old('first_name', $user->first_name) }}">
						@error('first_name')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Second name</span>
						<input type="text" name="second_name" class="input"
								value="{{ old('second_name', $user->second_name) }}">
						@error('second_name')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>
				
				<label>
						<span class="label">Nationality</span>
						<input type="text" name="nationality" class="input"
								value="{{ old('nationality', $user->nationality) }}">
						@error('nationality')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Ethnicity</span>
						<select name="ethnicity" class="select">
							@foreach($ethnicity_arr as $ethnicity)
								<option value="{{ $ethnicity->value }}"
											@if(old('ethnicity', $user->ethnicity) === $ethnicity->value) selected @endif>
											{{ __('enums.ethnicity.'.$ethnicity->value) }}
								</option>
							@endforeach
						</select>
						@error('ethnicity')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Religion</span>
						<select name="religion" class="select">
							@foreach($religion_arr as $religion)
								<option value="{{ $religion->value }}"
											@if(old('religion', $user->religion) === $religion->value) selected @endif>
											{{ __('enums.religion.'.$religion->value) }}
								</option>
							@endforeach
						</select>
						@error('religion')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Languages spoken</span>
						<select name="language" class="select">
							@foreach($languages_arr as $language)
								<option value="{{ $language->value }}"
									@if(old('language', $user->language) === $language->value) selected @endif>
									{{ __('enums.language.'.$language->value) }}
								</option>
							@endforeach
						</select>
						@error('language')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Body type</span>
						<select name="body" class="select">
							@foreach($body_arr as $body)
								<option value="{{ $body->value }}"
									@if(old('body', $user->body) === $body->value) selected @endif>
									{{ __('enums.body.'.$body->value) }}
								</option>
							@endforeach
						</select>
						@error('body')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Education</span>
						<select name="education" class="select">
							@foreach($education_arr as $education)
								<option value="{{ $education->value }}"
									@if(old('education', $user->education) === $education->value) selected @endif>
									{{ __('enums.education.'.$education->value) }}
								</option>
							@endforeach
						</select>
						@error('education')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Occupation</span>
						<select name="occupation" class="select">
							@foreach($occupation_arr as $occupation)
								<option value="{{ $occupation->value }}"
									@if(old('occupation', $user->occupation) === $occupation->value) selected @endif>
									{{ __('enums.occupation.'.$occupation->value) }}
								</option>
							@endforeach
						</select>
						@error('occupation')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Star sign</span>
						<select name="star_sign" class="select">
							@foreach($star_sign_arr as $star_sign)
								<option value="{{ $star_sign->value }}"
									@if(old('star_sign', $user->star_sign) === $star_sign->value) selected @endif>
									{{ __('enums.star_sign.'.$star_sign->value) }}
								</option>
							@endforeach
						</select>
						@error('star_sign')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Status</span>
						<select name="relationship_status" class="select">
							@foreach($relationship_status_arr as $relationship_status)
								<option value="{{ $relationship_status->value }}"
									@if(old('relationship_status', $user->relationship_status) === $relationship_status->value) selected @endif>
									{{ __('enums.relationship_status.'.$relationship_status->value) }}
								</option>
							@endforeach
						</select>
						@error('relationship_status')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				<label>
						<span class="label">Do you have kids?</span>
						<select name="kids" class="select">
							@foreach($kids_arr as $kids)
								<option value="{{ $kids->value }}"
									@if(old('kids', $user->kids) === $kids->value) selected @endif>
									{{ __('enums.kids.'.$kids->value) }}
								</option>
							@endforeach
						</select>
						@error('kids')
						<span class="error">{{ $message }}</span>
						@enderror
				</label>

				
			</div>

			<div class="profile_text" style="margin-top: 10px;">

				<label>
					<span class="label">About yourself</span>
					<textarea name="about" class="input" maxlength="500">{{ old('about', $user->about) }}</textarea>
					@error('about')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>

			</div>
			
			<div class="profile_fields" style="margin-top: 10px;">

				@if(User::current()->hasPermission(Permission::MANAGE_ROLES))
						<label>
							<span class="label">Role</span>
							<select name="role_id" class="select">
								<option value="">(No role)</option>
								@foreach(Role::allRoles() as $role)
										<option value="{{ $role->id }}"
												@if(old('role_id', $user->role_id) === $role->id) selected @endif>
											{{ $role->name }}
										</option>
								@endforeach
							</select>
							@error('role_id')
							<span class="error">{{ $message }}</span>
							@enderror
						</label>
				@endif

						<label>
							<span class="label">Password</span>
							<input type="password" name="password" class="input" autocomplete="new-password">
							@error('password')
							<span class="error">{{ $message }}</span>
							@enderror
						</label>
			</div>
			
			<div class="p-2 flex jc-end">
				<button type="submit" class="btn btn-pink">{{ $user->exists ? 'Save' : 'Create' }}</button>
			</div>
		</form>
	</div>
@endsection
