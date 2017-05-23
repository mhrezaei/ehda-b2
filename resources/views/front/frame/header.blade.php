<!DOCTYPE html>
<html lang="{{ getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
    {{ Html::style('assets/css/front-style.min.css') }}
    @include('front.frame.scripts')
    @yield('head')
</head>