@php

use App\Enums\Gender;
use App\Enums\Ethnicity;
use App\Enums\Religion;
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
						<input type="text" name="username" class="input" value="{{ auth()->user()->username }}">
						<span class="error" data-for="username"></span>
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
						<input type="number" name="age" min="18" max="80" class="input" value="{{ auth()->user()->age }}">
						<span class="error" data-for="age"></span>
					</label>

					<label>
						<span class="label">First name</span>
						<input type="text" name="first_name" class="input" value="{{ auth()->user()->first_name }}">
						<span class="error" data-for="first_name"></span>
					</label>

					<label>
						<span class="label">Second name</span>
						<input type="text" name="second_name" class="input" value="{{ auth()->user()->second_name }}">
						<span class="error" data-for="second_name"></span>
					</label>

					<label>
						<span class="label">Nationality</span>
						<input type="text" name="nationality" class="input" value="{{ auth()->user()->nationality }}"> <!-- {{ auth()->user()->nationality }} -->
						<span class="error" data-for="nationality"></span>
					</label>

					<label>
						<span class="label">Ethnicity</span>
						<select name="ethnicity" class="select">
							@foreach ($ethnicity_arr as $ethnicity)
								<option value="{{ $ethnicity->value }}"
									@if(auth()->user()->ethnicity === $ethnicity->value) selected @endif>{{ ucfirst(strtolower($ethnicity->name)) }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="ethnicity"></span>
					</label>

					<label>
						<span class="label">Religion</span>
						<select name="religion" class="select">
							@foreach ($religion_arr as $religion)
								<option value="{{ $religion->value }}"
									@if(auth()->user()->religion === $religion->value) selected @endif>{{ Religion::from($religion->value)->religion_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="religion"></span>
					</label>
					
					<label>
						<span class="label">Languages spoken</span>
						<input type="text" name="languages" class="input" value="{{ auth()->user()->languages }}"> 
						<span class="error" data-for="languages"></span>
					</label>

					<label>
						<span class="label">Body type</span>
						<select name="body" class="select">
							@foreach ($body_arr as $body)
								<option value="{{ $body->value }}"
									@if(auth()->user()->body === $body->value) selected @endif>{{ Body::from($body->value)->body_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="body"></span>
					</label>

					<label>
						<span class="label">Education</span>
						<select name="education" class="select">
							@foreach ($education_arr as $education)
								<option value="{{ $education->value }}"
									@if(auth()->user()->education === $education->value) selected @endif>{{ Education::from($education->value)->education_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="education"></span>
					</label>

					<label>
						<span class="label">Occupation</span>
						<select name="occupation" class="select">
							@foreach ($occupation_arr as $occupation)
								<option value="{{ $occupation->value }}" data-val="{{gettype(auth()->user()->occupation)}}"
									@if(auth()->user()->occupation === $occupation->value) selected @endif>{{ Occupation::from($occupation->value)->occupation_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="occupation"></span>
					</label>

					<label>
						<span class="label">Sexuality</span>
						<select name="sexuality" class="select">
							@foreach ($sexuality_arr as $sexuality)
								<option value="{{ $sexuality->value }}" data-val="{{auth()->user()->sexuality}}" 
									@if( auth()->user()->sexuality->value === $sexuality->value) selected @endif>{{ Sexuality::from($sexuality->value)->sexuality_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="sexuality"></span>
					</label>

					<label>
						<span class="label">Star sign</span>
						<select name="star_sign" class="select">
							@foreach ($star_sign_arr as $star_sign)
								<option value="{{ $star_sign->value }}"
									@if(auth()->user()->star_sign === $star_sign->value) selected @endif>{{ StarSign::from($star_sign->value)->star_sign_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="star_sign"></span>
					</label>

					<label>
						<span class="label">Status</span>
						<select name="relationship_status" class="select">
							@foreach ($relationship_status_arr as $relationship_status)
								<option value="{{ $relationship_status->value }}"
									@if(auth()->user()->relationship_status === $relationship_status->value) selected @endif>{{ RelationshipStatus::from($relationship_status->value)->relationship_status_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="relationship_status"></span>
					</label>

					<label>
						<span class="label">Do you have kids?</span>
						<select name="kids" class="select">
							@foreach ($kids_arr as $kids)
								<option value="{{ $kids->value }}"
									@if(auth()->user()->kids === $kids->value) selected @endif>{{ Kids::from($kids->value)->kids_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="kids"></span>
					</label>
{{--
					<label>
						<span class="label">Your country</span>
						<select name="have_kids" class="select">
							@foreach ($have_kids_arr as $have_kids)
								<option value="{{ $have_kids->value }}"
									@if(auth()->user()->have_kids === $have_kids->value) selected @endif>{{ HaveKids::from($have_kids->value)->have_kids_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="have_kids"></span>
					</label>

					<label>
						<span class="label">Your city</span>
						<select name="have_kids" class="select">
							@foreach ($have_kids_arr as $have_kids)
								<option value="{{ $status->value }}"
									@if(auth()->user()->have_kids === $have_kids->value) selected @endif>{{ HaveKids::from($have_kids->value)->have_kids_type_text() }}
								</option> 
							@endforeach                        
						</select>
						<span class="error" data-for="have_kids"></span>
					</label>
--}}
					
            </div>

				<div class="profile_text">
					<label>
						<span class="label">About yourself</span>
						<textarea name="about" class="input" maxlength="500">{{ auth()->user()->about }}</textarea> 
						<span class="error" data-for="about"></span>
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
