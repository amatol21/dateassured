@php

use App\Enums\Size;
use App\Enums\Sexuality;
use App\Enums\Purpose;
use App\Enums\VideoSessionStatus;
use App\Helpers\Svg;
use App\Models\VideoSession;
use Illuminate\Pagination\Paginator;

/**
 * @var VideoSession[]|Paginator $videoSessions
 */

@endphp

@extends('admin.index')

@section('adminContent')

    @include('admin.videoSessions.creationForm')

    <style>
        .vs_item_status {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border-radius: 1rem;
            background-color: #ccc;
            flex-shrink: 0;
        }

        .vs_item_status.status-0 {
            background-color: var(--color-green);
        }

        .vs_item_status.status-1 {
            background-color: var(--color-orange);
        }

        .vs_item_status.status-2 {
            background-color: var(--color-orange);
        }

        .vs_item_status.status-3 {
            background-color: #ccc;
        }
        .members {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .members_team {
            display: flex;
        }
        .members_team + .members_team {
            margin-left: 2rem;
        }
        .member + .member {
            margin-left: 0.5rem;
        }
        .member_no-member {
            width: 2rem;
            height: 2rem;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 1rem;
        }
        .member_photo {
            width: 2rem;
            height: 2rem;
            border-radius: 1rem;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .members_male .member_no-member,
        .members_male .member_photo {
            border-color: var(--color-blue);
        }
        .members_female .member_no-member,
        .members_female .member_photo {
            border-color: var(--color-pink);
        }
    </style>

    <div id="vs-talks-modal" class="modal" onclick="closeModal(this)">
        <div class="modal-content mb-1" style="margin-top: 2rem; width: 40rem; max-width: 100%" onclick="event.stopPropagation()">

        </div>
    </div>

    <div class="pad">
        <h2 class="account_title">
            Video sessions
            <button type="button" class="btn btn-pink btn-small ml-auto"
                    onclick="document.dispatchEvent(new CustomEvent('show-vs-creation-modal'))">Create video session</button>
        </h2>

        <form action="{{ route('admin.videoSessions', [], false) }}" id="vs-filter" class="users-filter mb-2 pl-2 pr-2 mt-2">
            <select name="sexuality" class="input input-small">
                <option value="" @if(request()->get('sexuality') === '') selected @endif>Any sexuality</option>
                <option value="{{ Sexuality::STRAIGHT->value }}" @if(request()->get('sexuality') === ''.Sexuality::STRAIGHT->value) selected @endif>Straight</option>
                <option value="{{ Sexuality::GAY->value }}" @if(request()->get('sexuality') === ''.Sexuality::GAY->value) selected @endif>Gay</option>
                <option value="{{ Sexuality::LESBIAN->value }}" @if(request()->get('sexuality') === ''.Sexuality::LESBIAN->value) selected @endif>Lesbian</option>
                <option value="{{ Sexuality::BI->value }}" @if(request()->get('sexuality') === ''.Sexuality::BI->value) selected @endif>Bi</option>
            </select>
            <select name="purpose" class="input input-small">
                <option value="" @if(request()->get('purpose') === '') selected @endif>Any purpose</option>
                <option value="{{ Purpose::CASUAL_FUN->value }}" @if(request()->get('purpose') === ''.Purpose::CASUAL_FUN->value) selected @endif>Casual fun</option>
                <option value="{{ Purpose::FRIENDSHIP_ONLY->value }}" @if(request()->get('purpose') === ''.Purpose::FRIENDSHIP_ONLY->value) selected @endif>Friendship only</option>
                <option value="{{ Purpose::SERIOUS_RELATIONSHIP->value }}" @if(request()->get('purpose') === ''.Purpose::SERIOUS_RELATIONSHIP->value) selected @endif>Serious relationship</option>
                <option value="{{ Purpose::MARRIAGE->value }}" @if(request()->get('purpose') === ''.Purpose::MARRIAGE->value) selected @endif>Marriage</option>
            </select>
            <select name="age" class="input input-small">
                <option value="0-100" @if(request()->get('age') === '') selected @endif>All Ages</option>
                <option value="18-26" @if(request()->get('age') === '18-26') selected @endif>18-26</option>
                <option value="27-35" @if(request()->get('age') === '27-35') selected @endif>27-35</option>
                <option value="36-44" @if(request()->get('age') === '36-44') selected @endif>36-44</option>
                <option value="45-54" @if(request()->get('age') === '45-54') selected @endif>45-54</option>
                <option value="55-65" @if(request()->get('age') === '55-65') selected @endif>55-65</option>
                <option value="66-100" @if(request()->get('age') === '66-100') selected @endif>66-70+</option>
            </select>
            <input type="hidden" name="sorting" value="reg-date">
            <input type="text" name="name" placeholder="ID or name..." value="{{ request()->get('name', '') }}" class="input input-small">
            <button type="submit" class="btn btn-small btn-pink">Search</button>
        </form>

        <div id="video-sessions" class="p-2">
            <table id="vs-table" class="w-100">
                <thead>
                <tr>
                    <th data-sort="id">ID</th>
                    <th data-sort="sexuality" class="center" style="width: 3rem">Sexuality</th>
                    <th data-sort="age">Ages</th>
                    <th data-sort="purpose">Purpose</th>
                    <th data-sort="country">Location</th>
                    <th data-sort="started_at">Start</th>
                    <th data-sort="status" class="center">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($videoSessions as $vs)
                    <tr class="dashed">
                        <td>{{ $vs->id }}</td>
                        <td class="center"><?= Svg::icon('sexuality-' . $vs->sexuality->toString(), 36, 35, 14) ?></td>
                        <td>{{ $vs->min_age.'-'.$vs->max_age }}</td>
                        <td>{{ $vs->purpose->name() }}</td>
                        <td>{{ __('enums.country.'.$vs->country) }}</td>
                        <td>{{ $vs->started_at }}</td>
                        <td class="center">
                            <div class="vs_item_status status-{{ $vs->status->value }}"
                                 title="{{ $vs->status->name() }}"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div class="members">
                                <div class="members_team members_male">
                                    @foreach($vs->getMaleTeam() as $user)
                                        @if($user === null)
                                            <div class="member"><div class="member_no-member"></div></div>
                                        @else
                                        <div class="member" title="{{ $user->getFullName() }}" data-vs="{{ $vs->id }}" data-user="{{ $user->id }}">
                                            <img src="{{ $user->getImageUrl(Size::SMALLEST) }}"
                                                 class="member_photo"
                                                 alt="{{ $user->getFullName() }}">
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="members_team members_female">
                                    @foreach($vs->getFemaleTeam() as $user)
                                        @if($user === null)
                                            <div class="member"><div class="member_no-member"></div></div>
                                        @else
                                        <div class="member" title="{{ $user->getFullName() }}" data-vs="{{ $vs->id }}" data-user="{{ $user->id }}">
                                            <img src="{{ $user->getImageUrl(Size::SMALLEST) }}"
                                                 class="member_photo"
                                                 alt="{{ $user->getFullName() }}">
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    <tr/>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($videoSessions->hasPages())
            <div class="p-2">
                {{ $videoSessions->appends($_GET)->links('common.ui.pagination') }}
            </div>
        @endif
    </div>


    <script>
        (() => {
            let talksModal = document.getElementById('vs-talks-modal');
            let talksContent = talksModal.querySelector('.modal-content');

            initTableSorting('#vs-table', '#vs-filter');

            async function clickHandler() {
                let videoSessionId = this.dataset.vs;
                let userId = this.dataset.user;

                try {
                    let res = await fetch('/admin/video-sessions/talks/' + videoSessionId + '/' + userId);
                    if (res.ok) {
                        setInnerHtml(talksContent, await res.text());
                        disableBodyScrollbar();
                        talksModal.classList.add('shown');
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            let photos = document.querySelectorAll('.member_photo');
            for (let i = 0; i < photos.length; i++) {
                photos[i].parentNode.addEventListener('click', clickHandler);
            }
        })();
    </script>

@endsection
