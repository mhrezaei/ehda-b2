<div class="col-xs-12 col-md-8">
    <h5>مارا در شبکه های اجتماعی دنبال کنید</h5>
    <ul class="social-links list-inline">
        {{ null, $telegram = setting()->ask('telegram_link')->gain() }}
        @if($telegram)
            <li><a href="{{ $telegram }}" target="_blank"><i class="icon icon-telegram"></i></a></li>
        @endif
        {{ null, $twitter = setting()->ask('twitter_link')->gain() }}
        @if($twitter)
            <li><a href="{{ $twitter }}" target="_blank"><i class="icon icon-twitter"></i></a></li>
        @endif
        {{ null, $facebook = setting()->ask('facebook_link')->gain() }}
        @if($facebook)
            <li><a href="{{ $facebook }}" target="_blank"><i class="icon icon-facebook"></i></a></li>
        @endif
        {{ null, $instagram = setting()->ask('instagram_link')->gain() }}
        @if($instagram)
            <li><a href="{{ $instagram }}" target="_blank"><i class="icon icon-instagram"></i></a></li>
        @endif
        {{ null, $aparat = setting()->ask('aparat_link')->gain() }}
        @if($aparat)
            <li><a href="{{ $aparat }}" target="_blank"><i class="icon icon-aparat"></i></a></li>
        @endif
    </ul>
    <p class="address">
        ملاصدرا، شیراز شمالی، خیابان حكیم اعظم، پلاك ۳۰، دانشگاه خاتم، طبقه ۲ انجمن اهدای عضو
        ایرانیان<br>(مشاهده
        برروی نقشه)<br>
        ۸۹۱۷۴۱۳۵ ۲۱ ۹۸ +<br>
        <a href="">info@ehda.center</a>
    </p>
</div>