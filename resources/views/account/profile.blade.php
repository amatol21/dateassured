@php

use App\Enums\Gender;
use App\Enums\Ethnicity;
use App\Enums\Religion;
use App\Enums\Languages;
use App\Enums\Body;
use App\Enums\Education;
use App\Enums\Occupation;
use App\Enums\Sexuality;
use App\Enums\StarSign;
use App\Enums\RelationshipStatus;
use App\Enums\Kids;
use App\Enums\Size;
use App\Models\User;

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

@endphp

@extends('account.index')

@section('title')
	Profile | DateAssured
@endsection

@section('accountContent')

	@include('account.changePasswordModal')
	@include('account.verifyEmailModal')

	<h2 class="account_title">Profile</h2>

	@php
	//dump(auth()->user()->sexuality->value );
	@endphp

	<div>
		<form action="{{ route('account.saveProfile', [], false) }}" method="POST" enctype="multipart/form-data"
				id="profile-form">
			@csrf

			@include('common.ui.photoInput', ['value' => User::current()->getPhotoUrl(Size::LARGE)])

			<div class="profile_fields">
				<label>
					<span class="label">Username</span>
					<input type="text" name="username" class="input" value="{{ old('username', auth()->user()->username) }}">
					<span class="error" data-for="username"></span>
					@error('username')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>

				<label>
					<span class="label">Email</span>
					<input type="email" class="input" value="{{ auth()->user()->email }}" disabled>
				</label>

				<label>
					<span class="label">Gender</span>
					<select name="gender" class="select">
						<option value="{{ Gender::MALE->value }}"
							@if(auth()->user()->gender === Gender::MALE) selected @endif> Male
						</option>
						<option value="{{ Gender::FEMALE->value }}"
							@if(auth()->user()->gender === Gender::FEMALE) selected @endif>Female
						</option>
					</select>
					<span class="error" data-for="gender"></span>
				</label>

				<label>
					<span class="label">Age</span>
					<input type="number" name="age" min="18" max="80" class="input" value="{{ old('age', auth()->user()->age) }}">
					<span class="error" data-for="age"></span>
					@error('age')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>

				<label>
					<span class="label">First name</span>
					<input type="text" name="first_name" class="input" value="{{ old('first_name', auth()->user()->first_name) }}">
					<span class="error" data-for="first_name"></span>
					@error('first_name')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>

				<label>
					<span class="label">Second name</span>
					<input type="text" name="second_name" class="input" value="{{ old('second_name', auth()->user()->second_name) }}">
					<span class="error" data-for="second_name"></span>
					@error('second_name')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>
{{--
				<label>
					<span class="label">Nationality</span>
					<input type="text" name="nationality" class="input" value="{{ old('nationality', auth()->user()->nationality) }}"> 
					<span class="error" data-for="nationality"></span>
					@error('nationality')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>
--}}

				<label>
					<span class="label">Your country</span>
					<input type="text" name="country" class="input" value="{{ old('country', auth()->user()->country) }}"> 
					<span class="error" data-for="country"></span>
					@error('country')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>

				<label>
					<span class="label">Ethnicity</span>
					<select name="ethnicity" class="select" data-selected="{{$ethnicity_value ?? 'false'}}">
						@foreach ($ethnicity_arr as $ethnicity)
							<option value="{{ $ethnicity->value }}"
								@if(old('ethnicity', auth()->user()->ethnicity) === $ethnicity->value) selected @endif>
									{{ __('enums.ethnicity.'.$ethnicity->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="ethnicity"></span>
				</label>

				<label>
					<span class="label">Religion</span>
					<select name="religion" class="select" data-selected="{{$religion_value ?? 'false'}}">
						@foreach ($religion_arr as $religion)
							<option value="{{ $religion->value }}"
								@if(old('religion', auth()->user()->religion) === $religion->value) selected @endif>
								{{ __('enums.religion.'.$religion->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="religion"></span>
				</label>
				
				<label>
					<span class="label">Languages spoken</span>
					<select name="language" class="select">
						@foreach($languages_arr as $language)
							<option value="{{ $language->value }}"
								@if(old('language', auth()->user()->language) === $language->value) selected @endif>
								{{ __('enums.language.'.$language->value) }}
							</option>
						@endforeach
					</select> 
					<span class="error" data-for="languages"></span>
				</label>

				<label>
					<span class="label">Body type</span>
					<select name="body" class="select" data-selected="{{$body_type_value ?? 'false'}}">
						@foreach ($body_arr as $body)
							<option value="{{ $body->value }}"
								@if(old('body', auth()->user()->body) === $body->value) selected @endif>
								{{ __('enums.body.'.$body->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="body"></span>
				</label>

				<label>
					<span class="label">Education</span>
					<select name="education" class="select" data-selected="{{$education_value ?? 'false'}}">
						@foreach ($education_arr as $education)
							<option value="{{ $education->value }}"
								@if(old('education', auth()->user()->education) === $education->value) selected @endif>
								{{ __('enums.education.'.$education->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="education"></span>
				</label>

				<label>
					<span class="label">Occupation</span>
					<select name="occupation" class="select" data-selected="{{$occupation_value ?? 'false'}}">
						@foreach ($occupation_arr as $occupation)
							<option value="{{ $occupation->value }}" data-val="{{gettype(auth()->user()->occupation)}}"
								@if(old('occupation', auth()->user()->occupation) === $occupation->value) selected @endif>
								{{ __('enums.occupation.'.$occupation->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="occupation"></span>
				</label>

				<label>
					<span class="label">Sexuality</span>
					<select name="sexuality" class="select" data-selected="{{$sexuality_value ?? 'false'}}">
						@foreach ($sexuality_arr as $sexuality)
							<option value="{{ $sexuality->value }}" data-val="{{auth()->user()->sexuality}}" 
								@if(old('sexuality', auth()->user()->sexuality) === $sexuality->value) selected @endif>
								{{ __('enums.sexuality.'.$sexuality->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="sexuality"></span>
				</label>

				<label>
					<span class="label">Star sign</span>
					<select name="star_sign" class="select" data-selected="{{$star_sign_value ?? 'false'}}">
						@foreach ($star_sign_arr as $star_sign)
							<option value="{{ $star_sign->value }}"
								@if(old('star_sign', auth()->user()->star_sign) === $star_sign->value) selected @endif>
								{{ __('enums.star_sign.'.$star_sign->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="star_sign"></span>
				</label>

				<label>
					<span class="label">Status</span>
					<select name="relationship_status" class="select" data-selected="{{$relationship_status_value ?? 'false'}}">
						@foreach ($relationship_status_arr as $relationship_status)
							<option value="{{ $relationship_status->value }}"
								@if(old('relationship_status', auth()->user()->relationship_status) === $relationship_status->value) selected @endif>
								{{ __('enums.relationship_status.'.$relationship_status->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="relationship_status"></span>
				</label>

				<label>
					<span class="label">Do you have kids?</span>
					<select name="kids" class="select" data-selected="{{$kids_value ?? 'false'}}">
						@foreach ($kids_arr as $kids)
							<option value="{{ $kids->value }}"
								@if(old('kids', auth()->user()->kids) === $kids->value) selected @endif>
								{{ __('enums.kids.'.$kids->value) }}
							</option> 
						@endforeach                        
					</select>
					<span class="error" data-for="kids"></span>
				</label>

				
			</div>

			<div class="profile_text">
				<label>
					<span class="label">About yourself</span>
					<textarea name="about" class="input" maxlength="500">{{ old('about', auth()->user()->about) }}</textarea> 
					<span class="error" data-for="about"></span>
					@error('about')
					<span class="error">{{ $message }}</span>
					@enderror
				</label>
			</div>

			<div class="profile_buttons">
					@if(!auth()->user()->hasVerifiedEmail())
						<button type="button" class="btn mr-1"
									onclick="document.dispatchEvent(new CustomEvent('verify-email'))">Verify email
						</button>
					@endif
					<button type="button" class="btn mr-1"
							onclick="document.dispatchEvent(new CustomEvent('change-password'))">Change password
					</button>
					<button type="submit" class="btn btn-pink">Save</button>
			</div>
		</form>
	</div>


	<script>
		(() => {
			let form = document.getElementById('profile-form');

			form.addEventListener('submit', async e => {
					e.preventDefault();
					clearFormErrors(form);
					await showSpinner(form);
					try {
						let res = await fetch(form.getAttribute('action'), {
							method: 'POST',
							body: new FormData(form),
							headers: {'X-Requested-With': 'XMLHttpRequest'}
						});
						if (res.ok) {
							document.dispatchEvent(new CustomEvent('update-user'));
							await hideSpinner(form, 'Saved');
							let html = await res.text();
							setInnerHtml('#content', html);

							let changed_select_arr = document.querySelectorAll("select[data-selected]");
							//console.log(changed_select_arr);
							changed_select_arr.forEach((elem) => {
								let attr_value = elem.getAttribute('data-selected');
								//console.log(attr_value);
								elem.selectedIndex = attr_value;
							});
						} else {
							let data = await res.json();
							showFormErrors(form, data);
							await hideSpinner(form);
						}
					} catch (e) {
						console.log(e);
						await hideSpinner(form);
					}
			});
		})();
	</script>
@endsection
