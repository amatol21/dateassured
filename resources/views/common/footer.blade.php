
<div id="footer">
    <div class="width-limiter">
        <div class="footer_links">
            <a href="#" class="footer_app-link">
                <img src="/images/google-play.png" alt="Google Play" class="footer_app-link-img">
            </a>
            <a href="#" class="footer_app-link">
                <img src="/images/app-store.png" alt="App Store" class="footer_app-link-img">
            </a>

            <div class="footer_follow">
                <div class="footer_follow-title">Follow Us:</div>
                <a href="#" class="footer_follow-link">
                    <svg viewBox="0 0 14 14" width="14" height="14" class="footer_follow-link-img">
                        <use href="/images/icons.svg#facebook"></use>
                    </svg>
                </a>
                <a href="#" class="footer_follow-link">
                    <svg width="50" height="50" viewBox="0 0 13.23 13.23" class="footer_follow-link-img">
                        <defs>
                            <linearGradient id="b-8">
                                <stop stop-color="#3771c8" offset="0" />
                                <stop stop-color="#3771c8" offset=".128" />
                                <stop stop-color="#60f" stop-opacity="0" offset="1" />
                            </linearGradient>
                            <linearGradient id="a">
                                <stop stop-color="#fd5" offset="0" />
                                <stop stop-color="#fd5" offset=".1" />
                                <stop stop-color="#ff543e" offset=".5" />
                                <stop stop-color="#c837ab" offset="1" />
                            </linearGradient>
                            <radialGradient id="d-1" cx="147.7" cy="473.5" r="65" gradientTransform="matrix(.0177 .08842 -.3644 .07299 167.7 -46.66)" gradientUnits="userSpaceOnUse" xlink:href="#b-8" />
                            <radialGradient id="c-9" cx="158.4" cy="578.1" r="65" gradientTransform="matrix(0 -.2017 .1876 0 -104.9 46.21)" gradientUnits="userSpaceOnUse" xlink:href="#a" />
                        </defs>
                        <rect width="13.23" height="13.23" rx="2.911" ry="2.911" fill="url(#c-9)" />
                        <rect width="13.23" height="13.23" rx="2.911" ry="2.911" fill="url(#d-1)" />
                        <circle cx="9.222" cy="4.003" r=".5821" fill="#fff" />
                        <rect x="2.17" y="2.17" width="8.891" height="8.891" rx="2.434" ry="2.434" fill="none"  stroke="#fff" stroke-width=".9221" />
                        <circle cx="6.615" cy="6.615" r="2.049" fill="none" stroke="#fff" stroke-width=".9221" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="footer_banner-wrap">
            <img src="/images/footer-banner.jpg" alt="Footer banner" class="footer_banner">
            <nav class="footer_menu">
                <a href="{{ route('aboutUs', [], false) }}" class="footer_menu_link">About Us</a>
                <a href="{{ route('termsOfUse', [], false) }}" class="footer_menu_link">Terms Of Use</a>
                <a href="{{ route('privacyPolicy', [], false) }}" class="footer_menu_link">Privacy Policy</a>
                <a href="{{ route('betaVersion', [], false) }}" class="footer_menu_link">Beta Version</a>
                <a href="{{ route('contactUs', [], false) }}" class="footer_menu_link">Contact Us</a>
                <a href="{{ route('faq', [], false) }}" class="footer_menu_link">FAQ</a>
            </nav>
        </div>

    </div>
    <div class="footer_copyright">
        <div class="width-limiter" style="text-align: center">
            Date Assured © {{ date('Y') }} - Online Speed Dating | All Rights Reserved
        </div>
    </div>
</div>
