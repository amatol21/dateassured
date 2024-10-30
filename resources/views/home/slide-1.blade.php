<div class="s1">
    <div class="width-limiter">
        <div class="s1_texts">
            <div class="s1_free-label">100% Free</div>
            <h1 class="s1_title">Date <br/> Assured</h1>
            <div class="s1_slogan" style="margin-bottom: 10px;">Online Speed Dating</div>
            <div class="flex">
					<a href="{{ route('register') }}"
						class="btn mr-1"
						style="width: 10rem"
						onclick="event.preventDefault(); document.dispatchEvent(new CustomEvent('show-reg-modal'))"
					>Registration</a>
					<a href="/faq" class="btn btn-pink">HOW IT WORKS?</a>
				</div>
        </div>

        <div class="s1_clock">
            <img src="/images/clock.png" alt="Clock" class="s1_clock-image">
            <div class="s1_clock_hours"></div>
            <div class="s1_clock_minutes"></div>
            <div class="s1_clock_seconds"></div>
        </div>
        <script>
            (() => {
                let h = document.querySelector('.s1_clock_hours');
                let m = document.querySelector('.s1_clock_minutes');
                let s = document.querySelector('.s1_clock_seconds');
                function nToDeg(n, max) { return Math.round(((n >= max ? n - max : n) / max) * 360); }
                function updateTime() {
                    let d = new Date();
                    h.style.transform = 'rotate(' + nToDeg(d.getHours(), 12) + 'deg)';
                    m.style.transform = 'rotate(' + nToDeg(d.getMinutes(), 60) + 'deg)';
                    s.style.transform = 'rotate(' + nToDeg(d.getSeconds(), 60) + 'deg)';
                }
                updateTime();
                setInterval(updateTime, 1000);
            })();
        </script>
        <img src="/images/people.jpg" alt="People" id="s1_people-img">
    </div>
</div>
