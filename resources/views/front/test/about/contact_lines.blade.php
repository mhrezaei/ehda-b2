<div class="col-md-6 col-sm-12">
    <p>
    </p>
    {{ null, $address = setting()->ask('address')->in(getLocale())->gain() }}
    @if($address)
        <h5>{{ trans('validation.attributes.address') }}:</h5>
        {{ $address }}
    @endif
    <p></p>
    <p>
    </p>
    {{ null, $tells = setting()->ask('tellephone')->gain() }}
    @if($tells)
        @if(!is_array($tells))
            {{ null, $tells = [$tells ] }}
        @endif
        <h5>
            {{ trans('validation.attributes.tel') }}:
            @foreach($tells as $key => $tell)
                @if($key)
                    ,
                @endif
                <a href="tel:{{ $tell }}">
                    {{ ad($tell) }}
                </a>
            @endforeach
        </h5>
    @endif
    {{ null, $emails = setting()->ask('email')->gain() }}
    @if($emails)
        @if(!is_array($emails))
            {{ null, $emails = [$emails ] }}
        @endif
        <h5>
            {{ trans('validation.attributes.email') }}:
            @foreach($emails as $key => $email)
                @if($key)
                    ,
                @endif
                <a href="mailto:{{ $email }}">
                    {{ ad($email) }}
                </a>
            @endforeach
        </h5>
    @endif
    <p></p>
    <p>
    <ul class="social-links list-inline">
        <h5>در شبکه&zwnj;های اجتماعی ما را دنبال کنید</h5>
        {{ null, $telegram = setting()->ask('telegram_link')->gain() }}
        @if($telegram)
            <li><a href="{{ $telegram }}" target="_blank"><i class="icon icon-telegram dark"></i></a></li>
        @endif
        {{ null, $twitter = setting()->ask('twitter_link')->gain() }}
        @if($twitter)
            <li><a href="{{ $twitter }}" target="_blank"><i class="icon icon-twitter dark"></i></a></li>
        @endif
        {{ null, $facebook = setting()->ask('facebook_link')->gain() }}
        @if($facebook)
            <li><a href="{{ $facebook }}" target="_blank"><i class="icon icon-facebook dark"></i></a></li>
        @endif
        {{ null, $instagram = setting()->ask('instagram_link')->gain() }}
        @if($instagram)
            <li><a href="{{ $instagram }}" target="_blank"><i class="icon icon-instagram dark"></i></a></li>
        @endif
        {{ null, $aparat = setting()->ask('aparat_link')->gain() }}
        @if($aparat)
            <li><a href="{{ $aparat }}" target="_blank"><i class="icon icon-aparat dark"></i></a></li>
        @endif
    </ul>
    </p>

</div>