<?php
    use App\Enums\Sexuality;
    use App\Enums\Purpose;
    use App\Models\Country;
?>

<div id="vs-creation-modal" class="modal">
    <form action="/admin/video-sessions/create" method="POST" id="vs-form" class="pad p-2"
          onclick="event.stopPropagation()" style="width: 40rem; max-width: 100%">
        @csrf
        <div class="form-grid">
            <label>
                <span>Sexuality</span>
                <select name="sexuality" class="input input-small" required>
                    <option value="">...</option>
                    <option value="{{ Sexuality::STRAIGHT }}">Straight</option>
                    <option value="{{ Sexuality::LESBIAN }}">Lesbian</option>
                    <option value="{{ Sexuality::GAY }}">Gay</option>
                    <option value="{{ Sexuality::BI }}">Bi</option>
                </select>
            </label>

            <label>
                <span>Purpose</span>
                <select name="purpose" class="input input-small" required>
                    <option value="">...</option>
                    <option value="{{ Purpose::CASUAL_FUN->value }}">{{ Purpose::CASUAL_FUN->name() }}</option>
                    <option value="{{ Purpose::MARRIAGE->value }}">{{ Purpose::MARRIAGE->name() }}</option>
                    <option
                        value="{{ Purpose::FRIENDSHIP_ONLY->value }}">{{ Purpose::FRIENDSHIP_ONLY->name() }}</option>
                    <option
                        value="{{ Purpose::SERIOUS_RELATIONSHIP->value }}">{{ Purpose::SERIOUS_RELATIONSHIP->name() }}</option>
                </select>
            </label>

            <label>
                <span>Age group</span>
                <select name="age" class="input input-small" required>
                    <option value="">...</option>
                    <option value="0-100">All Ages</option>
                    <option value="18-26">18-26</option>
                    <option value="27-35">27-35</option>
                    <option value="36-44">36-44</option>
                    <option value="45-54">45-54</option>
                    <option value="55-65">55-65</option>
                    <option value="66-100">66-70+</option>
                </select>
            </label>

            <label>
                <span>Location</span>
                <select name="country" class="input input-small" required>
                    <option value="">...</option>
                    @foreach(Country::getAll() as $country)
                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </label>

            <label>
                <span>Starting time</span>
                <input type="datetime-local" name="started_at" class="input input-small" required>
            </label>

            <label>
                <span>Talk duration (in minutes)</span>
                <input type="number" name="talk_duration" value="5" class="input input-small" required>
            </label>

            <label>
                <span>Delay (in seconds)</span>
                <input type="number" name="delay_between_talks" value="5" class="input input-small" required>
            </label>

            <label>
                <span>Team size</span>
                <input type="number" name="team_size" value="5" class="input input-small" required>
            </label>
        </div>


        <div class="flex mt-1">
            <button type="button" class="btn btn-outlined-static mr-1 ml-auto" onclick="closeModal(this)">Cancel</button>
            <button type="submit" class="btn btn-pink">Create video session</button>
        </div>

    </form>
</div>


<script>
    (() => {
        let modal = document.getElementById('vs-creation-modal');
        let form = document.getElementById('vs-form');

        document.addEventListener('show-vs-creation-modal', () => {
            form.reset();
            disableBodyScrollbar();
            modal.classList.add('shown');
        });

        // This code removes placeholder from selects after choosing some option.
        function changeHandler() {
            if (this.value !== "") {
                let placeholder = this.querySelector('option[value=""]');
                if (placeholder !== null) this.removeChild(placeholder);
            }
        }

        let selects = document.getElementsByTagName('select');
        for (let i = 0; i < selects.length; i++) {
            selects[i].addEventListener('change', changeHandler);
        }

        // Handle video session creating.
        form.addEventListener('submit', e => {
            e.preventDefault();
            let data = new FormData(form);
            let ages = data.get('age').split('-');
            document.dispatchEvent(new CustomEvent('video-session-created', {
                detail: {
                    minAge: parseInt(ages[0]),
                    maxAge: parseInt(ages[1]),
                    purpose: parseInt(data.get('purpose')),
                    sexuality: parseInt(data.get('sexuality')),
                    teamSize: parseInt(data.get('team_size')),
                    startedAt: parseInt(Date.parse(data.get('started_at'))),
                    talkDuration: Math.round(parseInt(data.get('talk_duration')) * 60),
                    delayBetweenTalks: parseInt(data.get('delay_between_talks')),
                    country: data.get('country'),
                    region: "",
                    city: ""
                }
            }));
            closeModal(modal);
            setTimeout(() => window.location.reload(), 1000);
        });
    })();
</script>
