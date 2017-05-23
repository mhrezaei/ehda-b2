@extends('front.frame.frame')

@section('head')
    <title>{{ setting()->ask('site_title')->gain() }} | {{ trans('front.home') }}</title>
@endsection

{{--@section('content')--}}
{{--@include('front.home.slider')--}}
{{--@include('front.home.mouse_spacer')--}}
{{--@include('front.home.about')--}}
{{--@include('front.home.categories')--}}
{{--@include('front.home.drawing')--}}
{{--@include('front.home.comments')--}}
{{--@endsection--}}

{{--<html dir="rtl">--}}
{{--<head>--}}
{{--<meta charset="UTF-8">--}}
{{--<meta name="viewport" content="width=device-width,initial-scale=1">--}}
{{--<title>انجمن اهدای عضو ایرانیان</title>--}}
{{--<link rel="stylesheet" href="bootstrap.css">--}}
{{--<link rel="stylesheet" href="fonts.css">--}}
{{--<link rel="stylesheet" href="style.css">--}}
{{--<script src="js/jquery-3.1.0.min.js"></script>--}}
{{--<script src="js/bootstrap.min.js"></script>--}}
{{--</head>--}}


{{--<body class="rtl">--}}

@section('content')
    {!! Html::script ('assets/libs/owl.carousel/js/owl.carousel.min.js') !!}
    <div class="container-fluid">
        @include('front.home.carousel')
        @include('front.home.current-members')
        @include('front.home.events-carousel')
        @include('front.home.home-notes')
        @include('front.home.equation')
        @include('front.home.hot-links')
    </div>
    {!! Html::script ('assets/js/main.min.js') !!}
@endsection

{{--</body>--}}


{{--</html>--}}