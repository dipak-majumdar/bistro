<footer>
    {{-- <div class="wave footer"></div> --}}
    <div class="container margin_60_40 fix_mobile">

        <div class="row">
            <div class="col-12 mb-5">
                <div class="news-later-box text-center">
                    <h3>Get Our Latest Updates</h3>
                    <div class="" id="">
                        <div id="newsletter">
                            <div id="message-newsletter"></div>
                            <form method="post" action="assets/newsletter.php" name="newsletter_form" id="newsletter_form">
                                <div class="form-group">
                                    <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
                                    <button type="submit" id="submit-newsletter"><i class="arrow_carrot-right"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="follow_us text-center">
                            <ul>
                                <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                                <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                                <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                                <li><a href="#0"><i class="bi bi-whatsapp"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mb-5">
                <span class="love-msg">Made With <i class="bi bi-heart-fill"></i> For You!</span>
            </div>
        </div>
        <!-- /row-->
        <hr>
        <div class="row add_bottom_25">
            <div class="col-lg-6">
                <ul class="footer-selector clearfix">
                    {{-- <li>
                        <div class="styled-select lang-selector">
                            <select>
                                <option value="English" selected>English</option>
                                <option value="French">French</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Russian">Russian</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="styled-select currency-selector">
                            <select>
                                <option value="US Dollars" selected>US Dollars</option>
                                <option value="Euro">Euro</option>
                            </select>
                        </div>
                    </li> --}}
                    <li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="{{ asset('assets/web/img/cards_all.svg') }}" alt="" width="200" height="28" class="lazy"></li>
                </ul>
            </div>
            <div class="col-lg-6">
                <ul class="additional_links">
                    <li><a href="{{ route('terms-conditions') }}">About</a></li>
                    <li><a href="{{ route('terms-conditions') }}">Help</a></li>
                    <li><a href="{{ route('terms-conditions') }}">Terms and conditions</a></li>
                    <li><a href="{{ route('privacy-policy') }}">Privacy</a></li>
                    <li><span>© Bistro Developed By Dipak</span></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!--/footer-->