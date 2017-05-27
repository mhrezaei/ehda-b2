<header class="clearfix container-fluid">
    <div class="row top-bar bg-primary clearfix">
        <ul class="pull-right list-inline no-margin">
            <li class="has-child">
                <a href="/">ورود کاربران</a>
                <ul class="list-unstyled bg-primary">
                    <li><a href="/">اطلاعات کاربر</a></li>
                    <li><a href="/">خروج</a></li>
                </ul>
            </li><!--
  -->
            <li>
                <a href="/">ورود استان&zwnj;ها</a>
            </li>
        </ul>
        <a href="/" class="slogan pull-left">
            <span>اهدای عضو</span><span>اهدای زندگی</span>
        </a>
    </div>
    <div class="main-menu clearfix">
        <a href="/" class="col-xs-4 col-sm-4 col-md-3">
            <h1 class="main-logo">
                {{ null, $logo = setting()->ask('site_logo')->gain() }}
                @if($logo)
                    <img src="{{ url($logo) }}" alt="انجمن اهدای عضو ایرانیان" id="logo">
                @endif
                <span class="hidden">انجمن اهدای عضو ایرانیان</span>
            </h1>
        </a>
        <ul class="list-inline text-left">
            <li class="has-child">
                <a href="/">دانستن</a>
                <ul class="bg-primary mega-menu col-xs-12">
                    <ul class="list-unstyled pull-left text-right">
                        <h3>اخبار</h3>
                        <li><a href="/">اخبار ایران</a></li>
                        <li><a href="/">اخبار جهان</a></li>
                        <li><a href="/">اخبار مراکز فراهم&zwnj;آوری</a></li>
                    </ul>
                    <ul class="list-unstyled pull-left text-right">
                        <h3>بیشتر بدانیم</h3>
                        <li><a href="/">علمی</a></li>
                        <li><a href="/">فرهنگی</a></li>
                        <li><a href="/">سؤالات رایج</a></li>
                    </ul>
                </ul>
            </li>
            <li class="has-child">
                <a href="/">خواستن</a>
                <ul class="bg-primary mega-menu col-xs-12">
                    <ul class="list-unstyled pull-left text-right">
                        <h3>اخبار</h3>
                        <li><a href="/">اخبار ایران</a></li>
                        <li><a href="/">اخبار جهان</a></li>
                        <li><a href="/">اخبار مراکز فراهم&zwnj;آوری</a></li>
                    </ul>
                    <ul class="list-unstyled pull-left text-right">
                        <h3>بیشتر بدانیم</h3>
                        <li><a href="/">علمی</a></li>
                        <li><a href="/">فرهنگی</a></li>
                        <li><a href="/">سؤالات رایج</a></li>
                    </ul>
                </ul>
            </li>
            <li class="has-child">
                <a href="/">توانستن</a>
                <ul class="bg-primary mega-menu col-xs-12">
                    <ul class="list-unstyled pull-left text-right">
                        <h3>اخبار</h3>
                        <li><a href="/">اخبار ایران</a></li>
                        <li><a href="/">اخبار جهان</a></li>
                        <li><a href="/">اخبار مراکز فراهم&zwnj;آوری</a></li>
                    </ul>
                    <ul class="list-unstyled pull-left text-right">
                        <h3>بیشتر بدانیم</h3>
                        <li><a href="/">علمی</a></li>
                        <li><a href="/">فرهنگی</a></li>
                        <li><a href="/">سؤالات رایج</a></li>
                    </ul>
                </ul>
            </li>
            <a href="/organ_donation_card" class="ehda-card-menu">
                <span>کارت</span> اهدای عضو
                <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="29.218" height="24.25" viewBox="0 0 29.218 24.25"
                 fill="#fff">
              <path id="Rounded_Rectangle_1" data-name="Rounded Rectangle 1" class="cls-1"
                    d="M286.086,28.556l-0.17-.17-3.537-3.537-6.9-6.9A7.5,7.5,0,0,1,286.086,7.343l1.768,1.768,1.938-1.939a7.259,7.259,0,0,1,10.265,0L300.4,7.514a7.259,7.259,0,0,1,0,10.264l-7.242,7.242-3.366,3.366-0.17.17A2.5,2.5,0,0,1,286.086,28.556Z"
                    transform="translate(-273.313 -5.063)"></path>
            </svg>
          </span>
            </a>
        </ul>
    </div>
    @include('front.frame.donation_card')
</header>