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
	Search | DateAssured
@endsection

@section('accountContent')

	<h2 class="account_title">Search...</h2>

	@php
		//dump($users);
	@endphp

	<div class="search">

		<div class="search__content">
			<div class="search__pagination">
				{{ $users->links('common.ui.pagination') }}
			</div>

			<div class="search__items">
				@foreach($users as $user)
					@php
						$photo = json_decode($user->photo_json);
					@endphp
					<div class="search__item">
						<div class="search__container">
							@if(!empty($photo))
								<a href="#">
									<img src="https://d1c9d83fb7g6g1.cloudfront.net/{{$photo->medium}}?t={{$photo->t}}" alt="person photo" class="search__photo">
								</a>
							@elseif($user->gender->value == 0)
								<a href="#">
									<img src="{{asset('/images/avatar-male.jpg')}}" alt="person photo" class="search__photo">
								</a>
							@elseif($user->gender->value == 1)
								<a href="#">
									<img src="{{asset('/images/avatar-female.jpg')}}" alt="person photo" class="search__photo">
								</a>
							@endif
						</div>
						<p class="search__name">
							
								{{$user->first_name}} <br>
								{{$user->second_name}}
								<a href="#"></a>
						</p>
						{{--<p class="search__location"></p>--}}
						
						<input type="hidden" name="id" value="{{$user->id}}">
						@if(!empty($photo))
							<input type="hidden" name="photo" value="https://d1c9d83fb7g6g1.cloudfront.net/{{$photo->medium}}?t={{$photo->t}}">
						@elseif($user->gender->value == 0)
							<input type="hidden" name="photo" value="{{asset('/images/avatar-male.jpg')}}">
						@elseif($user->gender->value == 1)
							<input type="hidden" name="photo" value="{{asset('/images/avatar-female.jpg')}}">
						@endif
						<input type="hidden" name="nickname" value="{{$user->username}}">
						<input type="hidden" name="age" value="{{$user->age}}">
						<input type="hidden" name="country" value="{{$user->country}}">
						<input type="hidden" name="interests" value="{{$user->about}}">
					</div>
				@endforeach
			</div>
			
			<div class="search__pagination">
				{{ $users->links('common.ui.pagination') }}
			</div>

			<div class="search__info">

				<div class="search__container">
					<img src="" alt="person photo" class="search__photo">
				</div>
				<p class="search__nickname"></p>
				<p class="search__age"></p>
				<p class="search__country"></p>
				<p class="search__interests"></p>
			</div>
		</div>

		<script>
			(function() {

				function popupInfo(){

					const search = document.querySelector('.search');

					const searchInfo = document.querySelector('.search__info');
					searchInfoData = searchInfo.getBoundingClientRect();
					//console.log(searchData);
					searchInfo.style.display = 'none';

					const searchItems = document.querySelectorAll('.search__item');
					searchItems.forEach((elem, index, array) => {

						elem.addEventListener('mouseenter', (event) => {
							elem.classList.add('search__item_active');

							const usersInfoElements = elem.querySelectorAll('input');
							let usersPopupInfoArr = {};
							usersInfoElements.forEach((item) => {
								usersPopupInfoArr[item.name] = item.value;
							});
							
							searchInfo.querySelector('.search__photo').setAttribute('src', usersPopupInfoArr['photo']);
							searchInfo.querySelector('.search__nickname').textContent = `Nickname: ${usersPopupInfoArr['nickname']}`;
							searchInfo.querySelector('.search__age').textContent = `Age: ${usersPopupInfoArr['age']}`;
							searchInfo.querySelector('.search__country').textContent = `Country: ${usersPopupInfoArr['country']}`;
							searchInfo.querySelector('.search__interests').textContent = `About person: ${usersPopupInfoArr['interests']}`;

							const elemData = elem.getBoundingClientRect();
							searchInfo.style.display = 'block';
							searchData = search.getBoundingClientRect();
							searchInfo.style.top = elemData.bottom + window.pageYOffset - (searchData.top + window.pageYOffset) + 15 + 'px';

							elem.addEventListener('mouseleave', () => {
								elem.classList.remove('search__item_active');
								searchInfo.style.display = 'none';

							});

						});
					});
				}

				if(window.screen.availWidth > 992){
					popupInfo();
					window.onresize = function(){
						if(window.screen.availWidth > 992){
							popupInfo();
						}
					}
				}
				
			})();
		</script>
		


	</div>


@endsection
